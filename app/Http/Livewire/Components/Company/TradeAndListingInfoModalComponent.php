<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Livewire\Component;
use PDF;

class TradeAndListingInfoModalComponent extends Component
{
    public $isOpen = false;
    public $trade;

    protected $listeners = ['openTradeAndListingInfoModal' => 'openTrade'];

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

    public function openTrade(Trade $trade)
    {
        $this->trade = $trade;
        $this->toggleModal();
    }

    public function toggleModal()
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.company.trade-and-listing-info-modal-component');
    }
}
