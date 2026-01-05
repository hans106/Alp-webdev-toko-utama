<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class RestockVerificationController extends Controller
{
    public function __construct()
    {
        // Endpoint removed — return 410 Gone if accessed directly
        abort(410, 'Restock verification functionality has been removed.');
    }
}
