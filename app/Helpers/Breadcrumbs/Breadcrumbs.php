<?php
/**
 * Created by PhpStorm.
 * User: pixeledge
 * Date: 05/07/2018
 * Time: 15:13
 */

namespace App\Helpers\Breadcrumbs;


use Illuminate\Http\Request;

class Breadcrumbs
{
    protected $request;

    public function __construct(Request $request )
    {
        $this->request = $request;
    }

    public function segments()
    {
        return collect( $this->request->segments() )->map( function ( $segment ) {
            return new Segment( $this->request, $segment );
        })->toArray();
    }
}