<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Managers\CVParserManager;
use Illuminate\Http\Request;

class CVParserController extends Controller
{
    public function view()
    {
        return view('admin.services.cvParser.view');
    }

    public function parse(Request $request, CVParserManager $parser)
    {
        return $parser->process($request->file('upload')['file']);
    }
}