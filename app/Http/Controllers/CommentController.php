<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Comment;
use phpDocumentor\Reflection\Types\Null_;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Komen;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('authAdmin')->except('store');
    }
    public function index(Request $request)
    {
        //
        if (!empty($request->search)) {
            return view('admin.comments.index')->with([
                'comments' => Komen::where('id', 'like', "%{$request->search}%")
                    ->orWhere('comment', 'like', "%{$request->search}%")->paginate(5),
                'reviews' => Komen::where('status', 1)->count(),
                'reviewsArchive' => Komen::whereNotNull('deleted_at')->withTrashed()->count(),
                'Allreviews' =>  Komen::withTrashed()->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        } else {
            return view('admin.comments.index')->with([
                'comments' => Komen::latest()->paginate(5),
                'reviews' => Komen::where('status', 1)->count(),
                'reviewsArchive' => Komen::whereNotNull('deleted_at')->withTrashed()->count(),
                'Allreviews' =>  Komen::withTrashed()->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        }
    }
    public function getArhcive()
    {
        # code...
        return view('admin.comments.index')->with([
            'comments' => Komen::whereNotNull('deleted_at')->withTrashed()->paginate(5),
            'reviews' => Komen::where('status', 1)->count(),
            'reviewsArchive' => Komen::whereNotNull('deleted_at')->withTrashed()->count(),
            'Allreviews' =>  Komen::withTrashed()->count(),
            'Earning' => Transaksi::sum('total'),

        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {

        $comment = filter_var($request->comment, FILTER_SANITIZE_STRING);
        $userId = auth()->user()->id;
        if (!empty($comment)) {
            Komen::create([
                "comment" => $comment,
                "status" => 0,
                "user_id" => $userId,
            ]);
            return redirect()->route("resto.index")->with([
                "success" => "Your review is awaiting validation "
            ]);
        } else {
            return redirect()->route("resto.index")->with([
                "error" => "Sorry, it is not possible to enter an empty value in Reviwe !! "
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Komen  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Komen $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Komen $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Komen  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        //
        $comment = Komen::findOrFail($id);

        $comment->update([
            'status' => 1,
        ]);
        return redirect()->route('reviews.index')->with(['success' => 'Review Validated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    // Unarchive function
    public function Unarchive($id)
    {
        $comment = Komen::where('id', $id)->withTrashed()->first();
        $comment->update([
            'deleted_at' => null,
        ]);

        return redirect()->route('reviews.index')->with(['success' => 'Review Unarchived']);
    }
    public function destroy($id)
    {
        //
        $comment = Komen::findOrFail($id);
        $comment->status = 0;
        $comment->save();
        $comment->delete();
        return redirect()->route('reviews.index')->with(['success' => 'Review Archived']);
    }
}
