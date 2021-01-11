<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Livewire\Component;
use PDF;

class TradeAndListingInfoModalComponent extends Component
{
    public $isOpen = false;
    public $trade;

    protected $listeners = ['openTradeAndListingInfoModal' => 'toggleModal'];

    public function downloadPdf()
    {
        return response()->streamDownload(
            function () {
                $trade = $this->trade;
                $pdf = PDF::loadView('layouts.invoice', compact('trade'));
                echo $pdf->output();
            },
            'deal_invoice_' . $this->trade->id . '.pdf'
        );
    }

    public function toggleModal(Trade $trade = null)
    {
        $this->trade = $trade;
        $this->isOpen = ! $this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.company.trade-and-listing-info-modal-component');
    }
}
