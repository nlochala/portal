<?php

namespace App\Http\Controllers;

use App\Address;
use App\Helpers\Helpers;
use App\Phone;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * Destroy the Phone Number
     *
     * @param Phone $phone
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Phone $phone)
    {
        $phone->user_updated_id = auth()->id();
        $phone->user_updated_ip = Helpers::getUserIp();

        if ($phone->save()) {
            return $phone->delete();
        }

        return false;
    }

    /**
     * Delete the given item.
     *
     * @param Phone $phone
     * @return RedirectResponse
     * @throws Exception
     */
    public function profileDestroy(Phone $phone)
    {
        if($this->destroy($phone)){
            Helpers::flashAlert(
                'success',
                'The phone number has been successfully deleted.',
                'fa fa-check mr-1');
            return redirect()->back();
        }
        Helpers::flashAlert(
            'danger',
            'There was a problem deleting the phone. Please try again.',
            'fa fa-info-circle mr-1');
        return redirect()->back();
    }
}
