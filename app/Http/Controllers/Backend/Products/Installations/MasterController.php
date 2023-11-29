<?php

namespace App\Http\Controllers\Backend\Products\Installations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

# MODELS
use App\Models\ProductInstallationArea;
use App\Models\ProductInstallationAreaId;
use App\Models\ProductInstallationColor;
use App\Models\ProductInstallationColorId;
use App\Models\ProductInstallationFloorSize;
use App\Models\ProductInstallationFloorSizeId;
use App\Models\ProductInstallationLocation;
use App\Models\ProductInstallationLocationId;
use App\Models\ProductInstallationSize;
use App\Models\ProductInstallationSizeId;

class MasterController extends Controller
{
    //
}
