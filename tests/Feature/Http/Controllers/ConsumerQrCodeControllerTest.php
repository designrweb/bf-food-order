<?php

namespace Tests\Feature\Http\Controllers;

/**
 * @group controller
 */

use App\ConsumerQrCode;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConsumerQrCodeControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('consumer-qr-codes.index'));

        $response->assertOk();
        $response->assertViewIs('consumer_qr_codes.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('consumer-qr-codes.create'));

        $response->assertOk();
        $response->assertViewIs('consumer_qr_codes._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $qrCode = create(ConsumerQrCode::class);

        $response = $this->get(route('consumer-qr-codes.show', $qrCode));

        $response->assertOk();
        $response->assertViewIs('consumer_qr_codes.view');
        $response->assertViewHas('resource', $qrCode);
    }

    /** @test */
    public function edit_returns_view()
    {
        $qrCode = create(ConsumerQrCode::class);

        $response = $this->get(route('consumer-qr-codes.edit', $qrCode));

        $response->assertOk();
        $response->assertViewIs('consumer_qr_codes._form');
        $response->assertViewHas('resource', $qrCode);
    }
}
