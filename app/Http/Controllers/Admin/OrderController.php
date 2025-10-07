<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use CodersFree\LaravelGreenter\Facades\Greenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['user', 'orderDetails.book', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        $order->load(['user', 'orderDetails.book', 'payment']);
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'paid'];
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,paid'
        ]);
        $order->update($validated);
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado de la orden actualizado exitosamente.');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->orderDetails()->delete();
        $order->payment()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Orden eliminada exitosamente.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,confirmed,rejected'
        ]);

        if ($order->payment) {
            $order->payment->update(['status' => $validated['payment_status']]);
            if ($validated['payment_status'] === 'confirmed') {
                $order->update(['status' => 'paid']);
            } elseif ($validated['payment_status'] === 'rejected') {
                $order->update(['status' => 'cancelled']);
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado de pago actualizado exitosamente.');
    }

    public function generateInvoice(Order $order)
    {
        \Log::info('generateInvoice called for order: ' . $order->id);

        $this->authorize('view', $order);

        if ($order->status !== 'paid' || $order->payment->status !== 'confirmed') {
            return back()->with('error', 'Solo se puede generar boleta si la orden está pagada y confirmada.');
        }

        try {
            $order->load(['user', 'orderDetails.book', 'payment']);

            // Totales SIN IGV (libros exonerados)
            $total = $order->orderDetails->sum('subtotal');
            $totalEnTexto = $this->numberToWords($total);

            $data = [
                "ublVersion" => "2.1",
                "tipoOperacion" => "0101",
                "tipoDoc" => "03",
                "serie" => "B001",
                "correlativo" => str_pad($order->id, 8, '0', STR_PAD_LEFT),
                "fechaEmision" => $order->created_at,
                "formaPago" => ['tipo' => 'Contado'],
                "tipoMoneda" => "PEN",
                "client" => [
                    "tipoDoc" => "1",
                    "numDoc" => $order->user->dni,
                    "rznSocial" => $order->user->name . ' ' . $order->user->last_name,
                ],
                "mtoOperExoneradas" => round($total, 2),
                "mtoIGV" => 0.00,
                "totalImpuestos" => 0.00,
                "valorVenta" => round($total, 2),
                "subTotal" => round($total, 2),
                "mtoImpVenta" => round($total, 2),
                "details" => $order->orderDetails->map(function ($detail) {
                    $valorUnitario = $detail->subtotal / $detail->quantity;
                    return [
                        "codProducto" => "LIB" . str_pad($detail->book_id, 5, '0', STR_PAD_LEFT),
                        "unidad" => "NIU",
                        "cantidad" => $detail->quantity,
                        "mtoValorUnitario" => round($valorUnitario, 2),
                        "descripcion" => $detail->book->title . ' - ' . $detail->book->author,
                        "mtoBaseIgv" => round($detail->subtotal, 2),
                        "porcentajeIgv" => 0.00,
                        "igv" => 0.00,
                        "tipAfeIgv" => "20",
                        "totalImpuestos" => 0.00,
                        "mtoValorVenta" => round($detail->subtotal, 2),
                        "mtoPrecioUnitario" => round($valorUnitario, 2),
                        "tributos" => [
                            [
                                "id" => "9997",
                                "nombre" => "EXO",
                                "codTipoTributo" => "VAT",
                                "mtoBase" => round($detail->subtotal, 2),
                                "mtoTributo" => 0.00,
                                "porcentaje" => 0,
                            ],
                        ],
                    ];
                })->toArray(),
                "legends" => [
                    [
                        "code" => "1000",
                        "value" => strtoupper($totalEnTexto),
                    ],
                ],
            ];

            \Log::info('Data prepared for Greenter');

            // VERIFICAR SI ESTAMOS EN MODO DESARROLLO SIN CERTIFICADO
            $certPath = config('greenter.fe.cert', '');
            $isDemoMode = empty($certPath) || !file_exists($certPath);

            if ($isDemoMode && app()->environment('local')) {
                \Log::info('Using DEMO mode - No certificate found');

                // Usar respuesta demo
                $response = $this->generateDemoResponse($order, $data);

                return view('admin.orders.invoice-preview', compact('order', 'data', 'response'))
                    ->with('demo_mode', true);
            }

            // Usar Greenter real
            try {
                $response = Greenter::send('invoice', $data);

                \Log::info('Greenter response received', [
                    'response_type' => get_class($response),
                    'has_xml' => !empty($response->getXml()),
                    'has_cdr' => !empty($response->getCdrZip())
                ]);

                if ($response->getXml()) {
                    $name = $response->getDocument()->getName();
                    \Log::info('Document name: ' . $name);

                    Storage::put("sunat/xml/{$name}.xml", $response->getXml());

                    if ($response->getCdrZip()) {
                        Storage::put("sunat/cdr/{$name}.zip", $response->getCdrZip());
                    }

                    \Log::info('About to return invoice-preview view');
                    return view('admin.orders.invoice-preview', compact('order', 'data', 'response'));
                } else {
                    \Log::error('Greenter failed - No XML generated');
                    return back()->with('error', 'Error al generar la boleta: No se pudo generar el XML');
                }
            } catch (\Exception $e) {
                \Log::error('Greenter exception: ' . $e->getMessage());
                return back()->with('error', 'Error en Greenter: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Invoice generation error: ' . $e->getMessage());
            return back()->with('error', 'Error al generar la boleta: ' . $e->getMessage());
        }
    }

    /**
     * Genera una respuesta demo para desarrollo
     */
    private function generateDemoResponse($order, $data)
    {
        return new class($order, $data) {
            private $order;
            private $data;

            public function __construct($order, $data)
            {
                $this->order = $order;
                $this->data = $data;
            }

            public function getXml()
            {
                // XML demo básico
                return '<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">
    <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>2.0</cbc:CustomizationID>
    <cbc:ID>B001-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT) . '</cbc:ID>
    <cbc:IssueDate>' . $this->order->created_at->format('Y-m-d') . '</cbc:IssueDate>
    <cbc:InvoiceTypeCode>03</cbc:InvoiceTypeCode>
    <cbc:DocumentCurrencyCode>PEN</cbc:DocumentCurrencyCode>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID="6">10154316189</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>GRUPOA&amp;T</cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>
    <cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID="1">' . $this->order->user->dni . '</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>' . $this->order->user->name . ' ' . $this->order->user->last_name . '</cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingCustomerParty>
    <cac:LegalMonetaryTotal>
        <cbc:PayableAmount currencyID="PEN">' . number_format($this->data["mtoImpVenta"], 2) . '</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
</Invoice>';
            }

            public function getCdrZip()
            {
                return null; // No hay CDR en demo
            }

            public function getDocument()
            {
                return new class($this->order) {
                    private $order;
                    public function __construct($order)
                    {
                        $this->order = $order;
                    }
                    public function getName()
                    {
                        return 'B001-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT);
                    }
                };
            }

            public function isSuccess()
            {
                return true;
            }
        };
    }



    public function downloadInvoicePdf(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['user', 'orderDetails.book', 'payment']);

        $pdf = Pdf::loadView('admin.orders.invoice-pdf', compact('order'));
        return $pdf->download('boleta_' . str_pad($order->id, 8, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function sendInvoiceEmail(Order $order)
    {
        $this->authorize('view', $order);

        try {
            Mail::to($order->user->email)
                ->send(new InvoiceMail($order));
            return back()->with('success', 'Boleta enviada por email exitosamente a ' . $order->user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar el email: ' . $e->getMessage());
        }
    }

    private function numberToWords($number)
    {
        $entero = floor($number);
        $decimales = round(($number - $entero) * 100);

        $letras = $this->numeroALetras($entero);

        return "SON {$letras} CON {$decimales}/100 SOLES";
    }

    private function numeroALetras($numero)
    {
        $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        $especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
        $decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        $centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

        if ($numero == 0) return 'CERO';
        if ($numero == 100) return 'CIEN';

        $letras = '';

        if ($numero >= 1000) {
            $miles = floor($numero / 1000);
            if ($miles == 1) {
                $letras .= 'MIL ';
            } else {
                $letras .= $this->numeroALetras($miles) . ' MIL ';
            }
            $numero %= 1000;
        }

        if ($numero >= 100) {
            $letras .= $centenas[floor($numero / 100)] . ' ';
            $numero %= 100;
        }

        if ($numero >= 20) {
            $letras .= $decenas[floor($numero / 10)];
            if ($numero % 10 > 0) {
                $letras .= ' Y ' . $unidades[$numero % 10];
            }
        } elseif ($numero >= 10) {
            $letras .= $especiales[$numero - 10];
        } elseif ($numero > 0) {
            $letras .= $unidades[$numero];
        }

        return trim($letras);
    }

    public function uploadInternalVoucher(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'internal_voucher' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
        ]);

        try {
            // Procesar el archivo
            if ($request->hasFile('internal_voucher')) {
                $file = $request->file('internal_voucher');
                $fileName = 'internal_voucher_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('internal_vouchers', $fileName, 'public');

                // Actualizar o crear el pago
                if ($order->payment) {
                    // Eliminar archivo anterior si existe
                    if ($order->payment->internal_voucher) {
                        Storage::disk('public')->delete($order->payment->internal_voucher);
                    }

                    $order->payment->update([
                        'internal_voucher' => $filePath,
                        'internal_voucher_uploaded_by' => auth()->id(),
                        'internal_voucher_uploaded_at' => now(),
                        'status' => 'confirmed' // Confirmar automáticamente al subir comprobante interno
                    ]);
                } else {
                    // Crear nuevo pago
                    $order->payment()->create([
                        'internal_voucher' => $filePath,
                        'internal_voucher_uploaded_by' => auth()->id(),
                        'internal_voucher_uploaded_at' => now(),
                        'payment_method' => 'interno',
                        'amount' => $order->orderDetails->sum('subtotal'),
                        'payment_date' => now(),
                        'status' => 'confirmed'
                    ]);
                }

                // Actualizar estado de la orden
                $order->update(['status' => 'paid']);

                \Log::info('Comprobante interno subido para orden', [
                    'order_id' => $order->id,
                    'file_path' => $filePath,
                    'user_id' => auth()->id()
                ]);

                return redirect()->route('admin.orders.show', $order)
                    ->with('success', 'Comprobante interno subido exitosamente.');
            }

            return back()->with('error', 'No se pudo subir el comprobante interno.');
        } catch (\Exception $e) {
            \Log::error('Error al subir comprobante interno: ' . $e->getMessage());
            return back()->with('error', 'Error al subir el comprobante interno: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar comprobante interno de pago
     */
    public function deleteInternalVoucher(Order $order)
    {
        $this->authorize('update', $order);

        try {
            if ($order->payment && $order->payment->internal_voucher) {
                // Eliminar archivo
                Storage::disk('public')->delete($order->payment->internal_voucher);

                // Actualizar registro
                $order->payment->update([
                    'internal_voucher' => null,
                    'internal_voucher_uploaded_by' => null,
                    'internal_voucher_uploaded_at' => null,
                    'status' => $order->payment->voucher_image ? 'confirmed' : 'pending'
                ]);

                \Log::info('Comprobante interno eliminado para orden', [
                    'order_id' => $order->id,
                    'user_id' => auth()->id()
                ]);

                return redirect()->route('admin.orders.show', $order)
                    ->with('success', 'Comprobante interno eliminado exitosamente.');
            }

            return back()->with('error', 'No hay comprobante interno para eliminar.');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar comprobante interno: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el comprobante interno: ' . $e->getMessage());
        }
    }
}
