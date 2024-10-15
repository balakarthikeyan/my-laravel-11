<?php

namespace App\Http\Controllers;

use App\Facades\TestFacade;
use App\Models\Note;
use App\Helpers\Helper;
use App\Enums\NoteStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CustomService;
use App\Interfaces\TestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends Controller implements TestInterface
{

    /**
     * Create a new class instance.
     */
    public function __construct(protected CustomService $customService)
    {
        //
    }

    /**
     * Write code on Helper Method
     *
     * @return response()
     */
    public function testHelperMethod()
    {
        $newDate = Helper::parseToYmd('03/01/2024');

        dd($newDate);
    }

    /**
     * Write code on Interface Method
     *
     * @return response()
     */
    public function testInferfaceMethod(): JsonResponse
    {
        return new JsonResponse(Note::all());
        // return response()->json( [ 'message' => 'success', 'data' => Note::all() ] );
    }

    /**
     * Write code on Service Method
     *
     * @return response()
     */
    public function testServiceMethod()
    {
        $this->customService->customServiceMethod();
    }

    /**
     * Write code on Enum Method
     *
     * @return response()
     */
    public function testEnumMethod()
    {
        $input = [
            'title' => 'Enum',
            'content' => 'This is a Enum',
            'status' => NoteStatus::Active
        ];

        $note = Note::create($input);

        dd($note->status, $note->status->value);
    }

    /**
     * Write code on Trait Method
     *
     * @return response()
     */
    public function testTraitMethod()
    {
        $input = [
            'title' => 'Trait',
            'content' => 'This is a Trait',
            'status' => NoteStatus::Active
        ];

        $note = Note::create($input);

        dd($note->toArray());
    }

    /**
     * Write code on Once Method
     *
     * @return response()
     */
    public function testOnceMethod()
    {
        $random1 = Str::random(10);
        $random2 = Helper::randomOnceMethod();
        $random3 = Str::random(10);
        $random4 = Helper::randomOnceMethod();

        dd($random1, $random2, $random3, $random4);
    }

    public function testFacadeMethod()
    {
        TestFacade::customServiceMethod();
        // TestFacade::randomOnceMethod();
    }
}
