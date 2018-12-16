<?php

namespace CodePress\CodeCategory\Controllers;


use CodePress\CodeCategory\Repository\CategoryRepositoryInterface;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCategoriesController extends Controller
{
    private $repository;
    private $response;

    public function __construct(ResponseFactory $response, CategoryRepositoryInterface $repository)
    {
        //$this->authorize('access_categories');
        $this->repository = $repository;
        $this->response = $response;
    }

    public function index()
    {
        $categories = $this->repository->all();
        return $this->response->view('codecategory::index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->repository->all();
        return view('codecategory::create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Request $request, $id)
    {
        $category = $this->repository->find($id);
        $this->authorizeForUser($request->user(), 'update', $category);
        /*if(!policy($category)->update($request->user(), $category)){
            abort(403);
        }*/
        /*if($request->user()->cannot('update', $category)){
            abort(403);
        };*/
        $categories = $this->repository->all();
        return $this->response->view('codecategory::edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (!isset($data['active'])) {
            $data['active'] = false;
        } else {
                $data['active'] = true;
        }

        if (!isset($data['parent_id']) || (isset($data['parent_id']) && $data['parent_id'])){
            $data['parent_id'] = null;
        }

        $category = $this->repository->update($data, $id);
        return redirect()->route('admin.categories.index');

        $this->repository->addCriteria()->addCriteria();
        $this->repository->find();

        $this->repository->ignoreCriteria()->all();

        $this->repository->find()->clearCriteria();
        //var_dump($data); die;
        if(!isset($data['active'])){
            $data['active'] = false;
        }else{
            $data['active'] = true;
        }
        if(!isset($data['parent_id']) || (isset($data['parent_id']) && $data['parent_id'] == 0)){
            $data['parent_id'] = null;
        }
        $category = $this-$this->repository->update($data, $id);
        //var_dump($category); die;
        return redirect()->route('admin.categories.index');
    }
}