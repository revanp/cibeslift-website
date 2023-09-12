<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
