<?php

namespace App\Http\Controllers;

use App\HowWorksCategory;
use App\Page;
use App\QACategory;
use Doctrine\DBAL\Driver\IBMDB2\DB2Driver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(10);
        $Page  = 'pages';
        return view('newthemplate.Admin.pages', compact(['pages', 'Page']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Page = 'add-page';
        return view('newthemplate.Admin.add-page', compact(['Page']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (strpos($request->page, '/')) {
            return redirect(route('admin.pages.add-page'))->with('error', 'Page url should not start with. /');
        }
        if (!preg_match("#^[aA-zZ0-9\-_]+$#", $request->page)) {
            return redirect(route('admin.pages.add-page'))->with('error', 'Page url has invalid characters');
        }
        if ($request->page !== '/') {
            if (substr($request->page, -1) === '/') {
                return redirect(route('admin.pages.add-page'))->with('error', 'Page url must end without /');
            }
        }
        if (empty($request->title)) {
            return redirect(route('admin.pages.add-page'))->with('error', 'Title has been required');
        }
        $old_page = Page::where('page', $request->page)->first();
        if ($old_page !== null) {
            return redirect(route('admin.pages.add-page'))->with('error', 'The page url has already been taken.');
        }

        $page                   = new Page;
        $page->page             = str_replace('/', '_', $request->page);
        $page->text_key         = str_replace('/', '_', $request->page);
        $page->title            = $request->title;
        $page->content          = $request['content'];
        $page->status           = $request->status;
        $page->meta_title       = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->save();

        $request->session()->flash('status', 'Page added!');

        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Page $page
     * @return \Illuminate\Http\Response
     */
    /*public function show(Page $page)
    {
        if ($page->status == 'published') {
            return view('newthemplate.pages', compact(['page']));
        } else {
            if(!Auth::check()){
                return redirect("/");
            }

            if(view()->exists('newthemplate.'.$page)){

                return view('newthemplate.'.$page,[
                    'Page'=>$page,
                ]);

            }else{

                return redirect("/");

                // return view('newthemplate.index',[
                //     'Page'=>'dashboard',
                // ]);

            }
        }
    }*/

    public function show($slug = '/')
    {
        if ($slug !== '/')
            $page = Page::where('page', $slug)->first();
        else
            $page = Page::where('page', $slug)->first();
        if ($page == null || $page->status !== 'published') {
            App::abort(404);
        }

        try {
            return $this->{$page->text_key}($page);
        } catch (\Exception $e) {
        }

        return view('site.pages.show', [
            'content' => $page->content,
            'page'    => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $Page = 'edit-page';
        return view('newthemplate.Admin.add-page', compact(['page', 'Page']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (strpos($request->page, '/')) {
            return redirect()->back()->with('error', 'Page should not start with. /');
        }
        if (!preg_match("#^[aA-zZ0-9\-_]+$#", $request->page)) {
            return redirect()->back()->with('error', 'Page has invalid characters');
        }
        if ($request->page !== '/') {
            if (substr($request->page, -1) === '/') {
                return redirect()->back()->with('error', 'Page url must end without /');
            }
        }
        if (empty($request->title)) {
            return redirect()->back()->with('error', 'Title has been required');
        }

        $page                   = Page::where('page', $request->page)->first();
        $page->page             = str_replace('/', '_', $request->page);
        $page->text_key         = str_replace('/', '_', $request->page);
        $page->title            = $request->title;
        $page->content          = $request['content'];
        $page->status           = $request->status;
        $page->meta_title       = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->save();
        $request->session()->flash('status', 'Page added!');

        return redirect()->route('pages.index');

        /*        $page->fill($request->all())->save();
                $request->session()->flash('status', 'Page updated!');
                if ($page->status == 'published') {
                    return redirect()->route('pages.show', ['page' => $page]);
                } else {
                    return redirect()->route('pages.index');
                }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json(['status' => 'success', 'success' => 'Sucessfully delete voucher code']);
    }

    public function howItWorks()
    {
        $howWorksCategories = HowWorksCategory::all();

        return view('site.pages.howWorks', compact('howWorksCategories'));
    }

    public function qaCategories()
    {
        $QACategories = QACategory::all();

        return view('site.pages.qaCategories', compact('QACategories'));
    }

    public function qaCategory($slug)
    {
        $QACategory = QACategory::where('slug', $slug)->firstOrFail();
        $QAItems    = $QACategory->items;

        return view('site.pages.qaCategory', compact('QAItems', 'QACategory'));
    }

    public function notification()
    {
        $authUser      = Auth::user();
        $notifications = $authUser->getNotifications();
        $notifications = array_reverse($notifications);
        $authUser->readNotifications(collect($notifications)->pluck('id')->toArray());

        return view('site.pages.notification', compact('notifications'));
    }

    public function terms_conditions($page)
    {
        return view('site.pages.termsConditions', compact('page'));
    }

    public function our_story($page)
    {
        dd($page);
        return view('site.pages.ourStory', compact('page'));
    }

    public function contact_administration($page)
    {
        return view('site.pages.contact-administration', compact('page'));
    }
}
