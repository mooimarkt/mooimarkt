<?php

namespace App\Http\Controllers\Admin;

use App\SubCategory;
use App\Transaction;
use Illuminate\Support\Facades\Storage;
use PDF;
use Auth;
use Image;
use App\Activity;
use App\Ads;
use App\AdsImages;
use App\AdsReport;
use App\Breadcrumb;
use App\PackageTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingsController extends Controller
{
    /**
     * Allowed mimetype.
     *
     * @var array
     */
    public $allowed = [
        'image/gif',
        'image/png',
        'image/jpeg',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listings()
    {
        $ads = Ads::orderBy('created_at')
            ->paginate(10);

        return view('newthemplate.Admin.listings', [
            'Page' => 'listings',
            'ads' => $ads,
        ]);
    }

    public function payments()
    {
        $payments = Transaction::latest()->paginate(10);

        return view('newthemplate.Admin.payments', [
            'Page' => 'payments',
            'payments' => $payments,
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
     * Store a newly created ads image in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request, Ads $ads)
    {
        $images = array();
        foreach ($request->file('files') as $image) {
            try {
                // Check mime
                if (!in_array($image->getClientMimeType(), $this->allowed)) {
                    $errors[] = 'Mime type: ' . $image->getClientMimeType() . ' not allowed';
                    continue;
                }

                $name = uniqid(\Illuminate\Support\Facades\Auth::user()->id . '_') . "." . $image->getClientOriginalExtension();
                Storage::putFileAs('/public/uploads/' . Auth::user()->id, $image, $name);

                // Resize image
                $preview = Image::make($image)
                    ->resize(263, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })// resize the image to a width of 740 and constrain aspect ratio (auto height)
                    ->resize(null, 316, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }); // resize the image to a height of 457 and constrain aspect ratio (auto width)
                $folder = config('image.folder') . Auth::user()->id . '/'; // save to folder
                $path = public_path($folder); // full path for saving
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                } // create dir if not exist
                $preview->save($path . $name); // save resized image

                // create image
                $images[] = AdsImages::create([
                    'adsId' => $ads->id,
                    'imagePath' => $folder . $name
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => !empty($errors) ? 'error' : 'success',
            'errors' => !empty($errors) ? $errors : 0,
            'images' => $images,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AdsImage $adsimage
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(AdsImages $adsimages)
    {
        $adsimages->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param int $user
     *
     * @return \Illuminate\Http\Response
     */
    public function user($user)
    {
        $ads = Ads::orderBy('created_at')
            ->where('userId', $user)
            ->paginate(10);

        return view('newthemplate.Admin.listings', [
            'Page' => 'listings',
            'ads' => $ads,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $ads)
    {
        $images = AdsImages::where('adsId', $ads->id)->get();

        $subcategory = SubCategory::find($ads->subCategoryId) ?? null;
        $category = $subcategory->Category;
        $productSizes = implode(', ', $ads->sizes->pluck('title')->all());
        $productConditions = implode(', ', $ads->conditions->pluck('title')->all());
        $productColors = implode(', ', $ads->colors->pluck('title')->all());

        return view('newthemplate.Admin.listing-management', [
            'Page' => 'listing-management',
            'ads' => $ads,
            'images' => $images,

            'category' => $category,
            'subcategory' => $subcategory,
            'productSizes' => $productSizes,
            'productConditions' => $productConditions,
            'productColors' => $productColors,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf(Ads $ads)
    {
        // $images = AdsImages::where( 'adsId', $ads->id )->get();

        $pdf = PDF::loadView('newthemplate.Admin.pdf', compact('ads'));
        return $pdf->download('add-details-' . $ads->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ads $ads)
    {
        return view('newthemplate.Admin.edit-page', [
            'Page' => 'edit-page',
            'ads' => $ads,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ads $ads)
    {
        $ads->fill($request->all())->save();

        return redirect()->route('admin.ads.show', ['ads' => $ads->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ads $ads)
    {
        $ads->delete();

        return redirect("/admin/listings");
    }

    public function ChaneAdsStatus(Request $request, $aid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $req = $request->validate([
            'adsStatus' => 'required'
        ]);

        $aid = intval($aid);

        $Ads = Ads::find($aid);

        if (!is_null($Ads)) {

            $Ads->adsStatus = $req['adsStatus'];
            $Ads->save();

            return response()->json(['status' => 'success', "message" => "Changed"]);

        }

        return response()->json(['status' => 'error', "message" => "Ads not find"]);

    }

    /**
     * update custom breadcrumb for ads
     *
     * @param Request $request [description]
     *
     * @return [type]           [description]
     */
    public function breadcrumb(Request $request, $ads)
    {
        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }
        $flight = Breadcrumb::updateOrCreate(
            ['adsId' => $ads, 'type' => $request->type],
            ['content' => $request->content]
        );
        $request->session()->flash('status', 'Breadcrumb updated!');

        return redirect()->back();
    }


    public function tickets(Request $request)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return redirect()->back();
        }

        $type = $request->exists("type") ? $request->type : "created";

        $Tickets = AdsReport::with("Ad")->where("status", $type);

        return view('newthemplate.Admin.tickets', [
            'Page' => 'tickets',
            'Tickets' => $Tickets->paginate(15),
            "Counts" => AdsReport::selectRaw("
			    SUM(CASE WHEN status = 'created' THEN 1 ELSE 0 END) AS created,
			    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) AS in_progress,
			    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
			    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected
            ")->get()
        ]);

    }

    public function ticket(Request $request, $tid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return redirect()->back();
        }

        $Ticket = AdsReport::find($tid);

        if (is_null($Ticket)) {
            return redirect("/admin/tickets/");
        }

        if ($Ticket->status == "created") {
            $Ticket->status = "in_progress";
            $Ticket->save();
        }

        return view('newthemplate.Admin.ticket', [
            'Page' => 'ticket',
            "Ticket" => $Ticket,
            "Counts" => AdsReport::selectRaw("
			    SUM(CASE WHEN status = 'created' THEN 1 ELSE 0 END) AS created,
			    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) AS in_progress,
			    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
			    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected
            ")->get()
        ]);

    }

    public function ticket_api(Request $request)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', 'message' => "please auth"]);
        }

        $req = $request->validate([
            'action' => "required|string"
        ]);

        switch ($req['action']) {
            case 'update':

                if ($request->exists('tid') && $request->exists('ticket')) {

                    $Ticket = AdsReport::find($request->tid);

                    if (!is_null($Ticket)) {

                        $Ticket->update($request->ticket);
                        return response()->json(['status' => 'success', 'message' => "updated!"]);

                    }

                    return response()->json(['status' => 'error', 'message' => "ticket with id {$request->tid} not found"]);

                }

                return response()->json(['status' => 'error', 'message' => "`tid` or `ticket` is not set"]);

                break;
            case 'remove':

                if ($request->exists('tid')) {

                    $Ticket = AdsReport::find($request->tid);

                    if (!is_null($Ticket)) {

                        $Ticket->delete();
                        return response()->json(['status' => 'success', 'message' => "deleted!"]);

                    }

                    return response()->json(['status' => 'error', 'message' => "ticket with id {$request->tid} not found"]);

                }

                return response()->json(['status' => 'error', 'message' => "`tid` is not set"]);

                break;
            case 'create':
                if ($request->exists('ticket')) {

                    $ticket = AdsReport::create($request->ticket);

                    return response()->json(['status' => 'success', 'message' => "`created", "ticket" => $ticket]);

                }

                return response()->json(['status' => 'error', 'message' => "`ticket` is not set"]);

                break;
            case 'blockad':

                if ($request->exists('tid')) {

                    $Ticket = AdsReport::find($request->tid);

                    if (!is_null($Ticket)) {

                        $Ticket->Ad->adsStatus = "blocked-" . $Ticket->Ad->adsStatus;
                        $Ticket->Ad->save();

                        return response()->json(['status' => 'success', 'message' => "blocked"]);

                    }

                    return response()->json(['status' => 'error', 'message' => "ticket with id {$request->tid} not found"]);

                }

                return response()->json(['status' => 'error', 'message' => "`tid` is not set"]);

                break;
            case 'removead':

                if ($request->exists('tid')) {

                    $Ticket = AdsReport::find($request->tid);

                    if (!is_null($Ticket)) {

                        $Ticket->Ad->delete();

                        return response()->json(['status' => 'success', 'message' => "removed"]);

                    }

                    return response()->json(['status' => 'error', 'message' => "ticket with id {$request->tid} not found"]);

                }

                return response()->json(['status' => 'error', 'message' => "`tid` is not set"]);

                break;
            case 'unblock':

                if ($request->exists('tid')) {

                    $Ticket = AdsReport::find($request->tid);

                    if (!is_null($Ticket)) {

                        if (strpos($Ticket->Ad->adsStatus, "blocked-") === 0) {

                            $Ticket->Ad->adsStatus = substr($Ticket->Ad->adsStatus, 8);
                            $Ticket->Ad->save();

                            return response()->json(['status' => 'success', 'message' => "unblocked"]);

                        }

                        return response()->json(['status' => 'error', 'message' => "ad not blocked"]);

                    }

                    return response()->json(['status' => 'error', 'message' => "ticket with id {$request->tid} not found"]);

                }

                return response()->json(['status' => 'error', 'message' => "`tid` is not set"]);

                break;
            default:
                return response()->json(['status' => 'error', 'message' => "no such action"]);
                break;
        }

        return response()->json(['status' => 'error', 'message' => "wrong request"]);

    }

    /**
     * Get meetings activity
     *
     * @return \Illuminate\Http\Response
     */
    public function meetings()
    {
        $meetings = Activity::where('type', 'meeting')
            ->latest()
            ->paginate(10);
        $Page = 'meetings';
        return view('newthemplate.Admin.meetings', compact(['meetings', 'Page']));
    }
}
