<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddModeratorRequest;
use App\Http\Requests\RemoveModeratorRequest;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Models\User;
use App\Models\YearModerator;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{
    public function getAllModerators()
    {
        $moderators = User::where('type', 'مشرف')->get()->map->moderatorFormating();
        return LocalResponse::returnData('moderators', $moderators);
    }
    public function addModerator(AddModeratorRequest $request)
    {
        $moderator = User::create($request->values());
        $yearModerator = YearModerator::create([
            'moderator_id' => $moderator->id,
            'year_id' => $request->year_id,
        ]);
        $moderator->year = $yearModerator->yearFormation();
        return LocalResponse::returnData('moderator', $moderator, 'تم إنشاء المشرف بنجاح');
    }
    public function removeModerator(RemoveModeratorRequest $request)
    {
        $user = User::find($request->id); // select * from users where user.id = ?
        if ($user->type != 'مشرف') {
            return LocalResponse::returnMessage('هذا الرقم ليس لمشرف', 400);
        }
        $user->delete();
        return LocalResponse::returnMessage('تم حذف المشرف بنجاح');
    }
    public function editModerator(Request $request)
    {
        // info($request->all());
        // return;
        $user = User::find($request->id);
        if (isset($user)) {
            if ($user->type == 'مشرف') {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone_number = $request->phone_number;
                if (isset($request->password))
                    $user->password = Hash::make($request->password);
                $moderatorYear = YearModerator::where('moderator_id', $user->id)->first();
                $moderatorYear->delete();
                $user->save();
                YearModerator::create([
                    'moderator_id' => $user->id,
                    'year_id' => $request->year_id,
                ]);
                $user = User::where('id', $request->id)->first()->moderatorFormating();
                return LocalResponse::returnData('moderator', $user, 'تم التعديل بنجاح', 200);
            }
            return LocalResponse::returnMessage('هذا المستخدم ليس بمشرف', 400);
        }
        return LocalResponse::returnMessage('لا يوجد مستخدم بهذا الرقم', 400);
    }
}
