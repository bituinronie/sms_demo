<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Room\IndexRoomRequest,
    App\Http\Requests\Room\CreateRoomRequest,
    App\Http\Requests\Room\ShowRoomRequest,
    App\Http\Requests\Room\UpdateRoomRequest,
    App\Http\Requests\Room\ListRoomRequest,
    App\Http\Requests\Room\ArchiveRoomRequest,
    App\Http\Requests\Room\RestoreRoomRequest,
    App\Http\Requests\Room\DeleteRoomRequest;


// * REPOSITORIES
use App\Repositories\Room\IndexRoomRepository,
    App\Repositories\Room\CreateRoomRepository,
    App\Repositories\Room\ShowRoomRepository,
    App\Repositories\Room\UpdateRoomRepository,
    App\Repositories\Room\ListRoomRepository,
    App\Repositories\Room\ArchiveRoomRepository,
    App\Repositories\Room\RestoreRoomRepository,
    App\Repositories\Room\DeleteRoomRepository;

class RoomController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexRoomRepository   $index,
        CreateRoomRepository  $create,
        ShowRoomRepository    $show,
        UpdateRoomRepository  $update,
        ListRoomRepository    $list,
        ArchiveRoomRepository $archive,
        RestoreRoomRepository $restore,
        DeleteRoomRepository  $delete
    ){
        $this->index   = $index;
        $this->create  = $create;
        $this->show    = $show;
        $this->update  = $update;
        $this->list    = $list;
        $this->archive = $archive;
        $this->restore = $restore;
        $this->delete  = $delete;
    }


    protected function index(IndexRoomRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateRoomRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowRoomRequest $request, $branchCode, $roomCode) {
        return $this->show->execute($branchCode, $roomCode);
    }

    
    protected function update(UpdateRoomRequest $request, $branchCode, $roomCode) {
        return $this->update->execute($request, $branchCode, $roomCode);
    }

    
    protected function list(ListRoomRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveRoomRequest $request, $branchCode, $roomCode){
        return $this->archive->execute($branchCode, $roomCode);
    }
    
    
    protected function restore(RestoreRoomRequest $request, $branchCode, $roomCode){
        return $this->restore->execute($branchCode, $roomCode);
    }

    
    protected function delete(DeleteRoomRequest $request, $branchCode, $roomCode) {
        return $this->delete->execute($branchCode, $roomCode);
    }
}
