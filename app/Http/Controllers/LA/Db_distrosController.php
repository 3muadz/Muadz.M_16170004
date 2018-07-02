<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Db_distro;

class Db_distrosController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'adress', 'message'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Db_distros', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Db_distros', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Db_distros.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Db_distros');
		
		if(Module::hasAccess($module->id)) {
			return View('la.db_distros.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new db_distro.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created db_distro in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Db_distros", "create")) {
		
			$rules = Module::validateRules("Db_distros", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Db_distros", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.db_distros.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified db_distro.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Db_distros", "view")) {
			
			$db_distro = Db_distro::find($id);
			if(isset($db_distro->id)) {
				$module = Module::get('Db_distros');
				$module->row = $db_distro;
				
				return view('la.db_distros.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('db_distro', $db_distro);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("db_distro"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified db_distro.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Db_distros", "edit")) {			
			$db_distro = Db_distro::find($id);
			if(isset($db_distro->id)) {	
				$module = Module::get('Db_distros');
				
				$module->row = $db_distro;
				
				return view('la.db_distros.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('db_distro', $db_distro);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("db_distro"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified db_distro in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Db_distros", "edit")) {
			
			$rules = Module::validateRules("Db_distros", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Db_distros", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.db_distros.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified db_distro from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Db_distros", "delete")) {
			Db_distro::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.db_distros.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('db_distros')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Db_distros');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/db_distros/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Db_distros", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/db_distros/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Db_distros", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.db_distros.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
