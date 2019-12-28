<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Repositories\UploadRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class UploadController extends Controller
{
    private $uploadRepository;

    /**
     * UploadController constructor.
     * @param UploadRepository $uploadRepository
     */
    public function __construct(UploadRepository $uploadRepository)
    {
        parent::__construct();
        $this->uploadRepository = $uploadRepository;
    }

    public function index()
    {
        return view('medias.index');
    }

    /**
     * Get images paths
     * @param $id
     * @param $conversion
     * @param null $filename
     * @return mixed
     */
    public function storage($id, $conversion, $filename = null)
    {
        $array = explode('.', $conversion . $filename);
        $extension = strtolower(end($array));
        if (isset($filename)) {
            return response()->file(storage_path('app/public/' . $id . '/' . $conversion . '/' . $filename));
        } else {
            $filename = $conversion;
            return response()->file(storage_path('app/public/' . $id . '/' . $filename));
        }

    }

    public function all(UploadRequest $request, $collection = null)
    {
        $allMedias = $this->uploadRepository->allMedia($collection);
        return $allMedias->toJson();
    }


    public function collectionsNames(UploadRequest $request)
    {
        $allMedias = $this->uploadRepository->collectionsNames();
        return $this->sendResponse($allMedias, 'Get Collections Successfully');
    }
    /**
     * @param UploadRequest $request
     */
    public function store(UploadRequest $request)
    {
        $input = $request->all();
        try {
            $upload = $this->uploadRepository->create($input);
            $upload->addMedia($input['file'])
                ->withCustomProperties(['uuid' => $input['uuid']])
                ->toMediaCollection($input['field']);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }
    }

    /**
     * clear cache from Upload table
     */
    public function clear(UploadRequest $request)
    {
        $input = $request->all();
        if ($input['uuid']) {
            $result = $this->uploadRepository->clear($input['uuid']);
            return $this->sendResponse($result, 'Media deleted successfully');
        }
        return $this->sendResponse(false, 'Error will delete media');

    }

    /**
     * clear all cache
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAll()
    {
        $this->uploadRepository->clearAll();
        return redirect()->back();
    }
}
