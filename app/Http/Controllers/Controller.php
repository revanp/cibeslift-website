<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function requestDatatables(array $params=array())
    {
        $datas = [];

        $data['draw'] = $params['draw'];

        if (isset($params['order']) && !empty($params['order'])) {
            $data['orderable'] = [];
            foreach ($params['order'] as $key => $order) {
                if ($params['columns'][$order['column']]['orderable'] == 'true') {
                    $data['orderable'][$params['columns'][$order['column']]['name']] = [
                        'column' => $params['columns'][$order['column']]['name'],
                        'dir'    => $order['dir']
                    ];
                }
            }
        } else {
            $data['orderable'] = [];
        }

        if (isset($params['columns']) && !empty($params['columns'])) {
            $data['searchable'] = [];
            foreach ($params['columns'] as $key => $column) {
                if ($column['searchable'] == 'true') {
                    $data['searchable'][] = $column['name'];
                }
            }
        } else {
            $data['searchable'] = [];
        }


        $data['search'] = ($params['search']['value']) ? $params['search']['value'] : '';

        $data['start']  = ($params['start']) ? $params['start'] : 0;
        $data['length'] = ($params['length']) ? $params['length'] : 0;

        return $data;
    }

    protected function storeFile($file, $model, $relation, $path, $content_type = null)
    {
        $document = $file;
        $fileName = $document->hashName();

        $data = [
            'content_type' => $content_type,
            'name' => $document->getClientOriginalName(),
            'path' => $path,
            'file_name' => $fileName,
            'type' => $document->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image',
            'mime_type' => $document->getMimeType(),
            'disk' => config('filesystems.default'),
            'extension' => $document->getClientOriginalExtension(),
            'size' => $document->getSize(),
        ];

        if ($model->$relation) {
            $model->$relation()->update($data);
        } else {
            $model->$relation()->create($data);
        }

        Storage::putFileAs("$path/", $document, $fileName, 'public');
    }
}
