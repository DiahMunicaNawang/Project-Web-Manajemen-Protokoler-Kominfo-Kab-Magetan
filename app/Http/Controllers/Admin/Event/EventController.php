<?php

namespace App\Http\Controllers\Admin\Event;

use App\Models\Events;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    protected $title = 'Manajement Event';
    protected $breadcrumb = [['url' => '/dashboard', 'title' => 'Dashboard'], ['url' => '/event', 'title' => 'Event']];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('admin.event.index', [
            'menus' => $this->getMenus(),
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('name')) {
                $events = Events::where('name', $request->name)->select('*');
            } elseif ($request->filled('start_date') && $request->filled('end_date')) {
                $startDateTime = $request->start_date . ' 00:00:00';
                $endDateTime = $request->end_date . ' 23:59:59';
                $events = Events::whereBetween('start_date', [$startDateTime, $endDateTime])
                    ->whereBetween('end_date', [$startDateTime, $endDateTime])->select('*');
            } elseif ($request->filled('dinas')) {
                $events = Events::where('dinas', $request->dinas)->select('*');
            } else {
                $events = Events::select('*');
            }
            

            $datatable = new DataTables;
            return $datatable->eloquent($events)
                ->addColumn('action', function ($event) {
                    return $this->getActionColumn($event);
                })
                ->addColumn('pdf_file', function ($event) {
                    return $this->getPdfColumn($event->file_pdf);
                })
                ->addColumn('time', function ($event) {
                    return $this->getDateColumn($event->start_date, $event->end_date);
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'pdf_file', 'time'])
                ->toJson();
        }
    }

    private function getActionColumn($event)
    {
        $arrowIcon = $this->getArrowIcon();
        $editMenuItem = '';
        $deleteMenuItem = '';

        if ($this->user->can('Event-update')) {
            $editMenuItem = '
                 <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" id="edit-product-button" data-id="' . $event->id . '" data-kt-docs-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#edit-product-modal">
                        Edit
                    </a>
                </div>
                <!--end::Menu item-->
            ';
        }

        if ($this->user->can('Event-delete')) {
            $deleteMenuItem = '
                   <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3"  data-id="' . $event->id . '" data-name="' . $event->name . '" id="delete-product-button" data-kt-docs-table-filter="delete_row">
                        Hapus
                    </a>
                </div>
                <!--end::Menu item-->
            ';
        }

        if ($editMenuItem == '' && $deleteMenuItem == '') {
            return '
                <span class="badge badge-secondary">Tidak Ada Aksi</span>
            ';
        } else {
            return '
            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Aksi
                <span class="svg-icon fs-5 m-0">
                    ' . $arrowIcon . '
                </span>
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                ' . $editMenuItem . '
                ' . $deleteMenuItem . '
            </div>
            <!--end::Menu-->
        ';
        }
    }

    private function getPdfColumn($pdfFile)
    {
        $fileExists = file_exists(public_path($pdfFile));
        $file = asset($pdfFile);

        if ($fileExists) {
            return '
                <a href="' . $file . '" target="_blank" class="btn btn-sm btn-light-primary btn-active-light-primary">Lihat</a>
            ';
        } else {
            return '
                <span class="badge badge-secondary">Tidak Ada File</span>
            ';
        }
    }

    private function getDateColumn($startDate, $endDate)
    {
        $formattedStartDate = date('d F Y (H:i)', strtotime($startDate));
        $formattedEndDate = date('d F Y (H:i)', strtotime($endDate));

        return '
            <span class="badge badge-light-primary">' . $formattedStartDate . '</span>
            <div class="fw-bolder text-center">-</div>
            <span class="badge badge-light-danger">' . $formattedEndDate . '</span>
        ';
    }

    public function show($id)
    {
        $event = Events::findOrFail($id);

        return $this->render('admin.event.show', [
            'event' => $event,
            'menus' => $this->getMenus(),
            'breadcrumb' => [
                ['url' => '/dashboard', 'title' => 'Dashboard'],
                ['url' => '/event/' . $event->id, 'title' => $event->name],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'dinas' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Check Dropzone for image or pdf null or not
        if ($request->pdf_file == null) {
            return ResponseFormatter::error('error', 'File Pdf Tidak boleh kosong');
        }

        try {
            DB::beginTransaction();

            Events::create([
                'name' => $request->name,
                'description' => $request->description,
                'dinas' => $request->dinas,
                'location' => $request->location,
                'file_pdf' => $request->pdf_file,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();

            return ResponseFormatter::success('success', 'Berhasil Membuat Event');
        } catch (\exception $e) {
            DB::rollBack();
            $this->deleteFileWhenFailedToStoreOrSuccessDelete($request->pdf_file);
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }

    public function edit($id)
    {
        $event = Events::findOrFail($id);

        $pdfFile = file_exists(public_path($event->file_pdf))
            ? json_encode([
                'path' => $event->file_pdf,
                'name' => basename($event->file_pdf),
                'size' => filesize(public_path($event->file_pdf)),
            ])
            : null;

        return response()->json([
            'product' => $event,
            'pdf_file' => $pdfFile,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'dinas' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Check Dropzone for image or pdf null or not
        if ($request->pdf_file == null) {
            return ResponseFormatter::error('File PDF Tidak Boleh Kosong');
        }

        try {
            DB::beginTransaction();

            $event = Events::findOrFail($id);
            $originalValues = $event->getOriginal();

            // Check if file_pdf has changed
            // If changed, delete the old file
            if ($request->hasFile('pdf_file') && $request->pdf_file != $originalValues['pdf_file']) {
                $this->deleteFileWhenFailedToStoreOrSuccessDelete($originalValues['pdf_file']);
            }

            $event->update([
                'name' => $request->name,
                'description' => $request->description,
                'dinas' => $request->dinas,
                'location' => $request->location,
                'file_pdf' => $request->pdf_file,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();

            return ResponseFormatter::success('success', 'Berhasil Mengubah Event');
        } catch (\exception $e) {
            DB::rollBack();
            return ResponseFormatter::error($e->getMessage(), 'error', 422);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $event = Events::findOrFail($id);
            $this->deleteFileWhenFailedToStoreOrSuccessDelete($event->file_pdf);
            $event->delete();

            DB::commit();

            return ResponseFormatter::success('success', 'Berhasil Menghapus Event');
        } catch (\exception $e) {
            DB::rollBack();
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }

    public function multipleDelete($ids)
    {
        try {
            DB::beginTransaction();

            $ids = explode(',', $ids);
            $events = Events::whereIn('id', $ids)->get();
            foreach ($events as $event) {
                $this->deleteFileWhenFailedToStoreOrSuccessDelete($event->file_pdf);
                $event->delete();
            }
            DB::commit();

            return ResponseFormatter::success('success', 'Berhasil Menghapus Event');
        } catch (\exception $e) {
            DB::rollBack();
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }
}
