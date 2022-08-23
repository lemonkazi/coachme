<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Age;

use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class AgeController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request, Age $age)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Age  $ages
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Request $request, Age $age)
    {
        $params = $request->all();

        if (!empty($age->id)) {
            $breadcrumb = array(
                array(
                    'name' => trans('global.Age List'),
                    'link' => '/ages'
                ),
                array(
                    'name' => trans('global.Age List'),
                    'link' => ''
                )
            );
            return view('admin.age.detail', [
                'pageInfo' =>
                [
                    'siteTitle'        => 'Manage Users',
                    'pageHeading'      => 'Manage Users',
                    'pageHeadingSlogan' => 'Here the section to manage all registered users'
                ],
                'data' =>
                [
                    'age' => Age::find($age->id),
                    'breadcrumb' =>  $breadcrumb,
                    'Title' =>  trans('global.age Detail')
                ]
            ]);
        }
        $query = $age->filter($params);

        $export = filter_var($request->input('export', false), FILTER_VALIDATE_BOOLEAN);

        try {
            $limit = (int) $request->input('limit', 20);
        } catch (\Exception $e) {
            $limit = 20;
        }

        if (!is_int($limit) || $limit <= 0) {
            $limit = 20;
        }
        if (isset($params['with'])) {
            $with = explode(',', $params['with']);

            $query->with($with);
        }
        if (isset($params['sort']) && !empty($params['sort'])) {
            $sort = $params['sort'];
            $sortExplode = explode('-', $params['sort']);
            $query->orderBy($sortExplode[0], $sortExplode[1]);
        } else {
            $sort = 'id-desc';
            $query->orderBy('id', 'desc');
        }
        $response = $query->paginate($limit);

        $breadcrumb = array(
            array(
                'name' => trans('global.Age List'),
                'link' => '/ages'
            )
        );
        // If export parameter true, it will return csv file
        if ($export) {
            // It maps model property (key) to column header (value)
            $headPropertyMapper = [
                'id' => 'ID',
                'name' => 'Name',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];

            $data = $user->dataProcessor($headPropertyMapper, $response);
            $headings = array_values($headPropertyMapper);

            // Create CollectionExport instance by passing file headers and data
            $collectionExportInstance = new CollectionExport($headings, $data);
            $fileName = date('Ymd_His') . '_certificates.csv';

            return Excel::download($collectionExportInstance, $fileName);
        } else {
            if (isset($params['page'])) {
                $page = !empty($params['page']) ? $params['page'] : 1;
            } else {
                $page = 1;
            }
            $total = $response->total();
            $sumary = '';
            if ($total > $limit) {
                $content = ($page - 1) * $limit + 1;
                $sumary = "Total " . $total . " Displaying " . $content . "～" . min($page * $limit, $total);
            }
            return view('admin.age.list', [
                'pageInfo' =>
                [
                    'siteTitle'        => 'Manage Users',
                    'pageHeading'      => 'Manage Users',
                    'pageHeadingSlogan' => 'Here the section to manage all registered users'
                ],
                'data' =>
                [
                    'ages'      =>  $response->appends(request()->except('page')),
                    'breadcrumb' =>  $breadcrumb,
                    'Title' =>  trans('global.Age List'),
                    'sumary' => $sumary,
                    'request' => $params,
                    'sort' => $sort,
                    'limit' => $limit
                ]
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $age = '';
        $title = 'Add Age';
        $breadcrumb = array(
            array(
                'name' => trans('global.All age'),
                'link' => '/ages'
            )
        );
        if (!empty($id)) {
            $age = Age::find($id);
            if (!$age) {
                return back();
            } else {
                $breadcrumb[] = array(
                    'name' => trans('global.Edit Age'),
                    'link' => ''
                );
                $title = trans('global.Edit Age');
            }
        } else {
            $breadcrumb[] = array(
                'name' => trans('global.Add Age'),
                'link' => ''
            );
        }

        return view('admin.age.add', [
            'pageInfo' =>
            [
                'siteTitle'        => 'Manage Users',
                'pageHeading'      => 'Manage Users',
                'pageHeadingSlogan' => 'Here the section to manage all registered users'
            ],
            'data' =>
            [
                'age'      =>  $age,
                'breadcrumb' =>  $breadcrumb,
                'Title' =>  $title
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $Authuser = $request->user();
        $rules = array(
            'name'   => 'required|string|max:255',
        );
        $messages = array(
            'name.required' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max')
        );
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            Toastr::warning('Error occured', $validator->errors()->all()[0]);
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            if (!Age::create($data)) {
                return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
            }
            Toastr::success(trans('global.A new Age has been created'), 'Success');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $id = null)
    {

        $data = $request->all();
        $Authuser = $request->user();
        $age = Age::find($id);
        if (!$age) {
            return back();
        }

        $rules = array(
            'name'   => 'filled|string|max:50',
        );
        $messages = array(
            'name.filled' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max'),
        );
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {

            Toastr::warning('Error occured', $validator->errors()->all()[0]);
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            if (!$age->update($data)) {
                return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
            }

            Toastr::success(trans('global.Age has been updated'), 'Success');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Age $age)
    {
        $age->delete();
        return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }
}
