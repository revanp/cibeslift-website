<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductProperty;
use App\Models\ProductPropertyId;
use App\Models\ProductPropertyValue;
use App\Models\ProductPropertyValueId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.pages.products.properties.index');
    }

    public function create()
    {
        $sort = ProductPropertyId::count() + 1;

        return view('backend.pages.products.properties.create', compact('sort'));
    }
}
