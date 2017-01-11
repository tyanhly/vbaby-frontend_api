<?php

namespace App\Http\Controllers;

use App\Repositories\ContentCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentCategoriesController extends Controller
{
    private $contentCategoryRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentCategoryRepository $contentCategoryRepo)
    {
        // Construct
        $this->contentCategoryRepo = $contentCategoryRepo;
    }

    /**
     * Action for route GET /
     * For API working check
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = [
            'message' => 'Hello from ContentCategory API Index',
        ];
        return new JsonResponse($response, 200);
    }

    /**
     * Action for route GET /v1/contentCategories/
     * Get all contentCategory from database
     *
     * @return array
     */
    public function indexContentCategories()
    {
        return $this->contentCategoryRepo->all();
    }

    /**
     * Action for route GET /v1/contentCategories/{id}
     * Get only one contentCategory by its id
     *
     * @param  int $id ContentCategory Id
     *
     * @return object
     */
    public function viewContentCategory($id)
    {
        return $this->contentCategoryRepo->find($id);
    }

    /**
     * Action for route POST /v1/contentCategories
     *
     * @param  Request $request New ContentCategory data
     *
     * @return object/json
     */
    public function createContentCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description', null),
            'parent_id' => $request->input('parent_id', null),
        ];

        $created = $this->contentCategoryRepo->create($data);
        if (!$created) {
            return response(['message' => 'Couldn\'t create ContentCategory'], 400);
        }
        return $created;
    }

    /**
     * Action for PUT /v1/contentCategories/{id}
     * Update a contentCategory
     *
     * @param  int  $id      ContentCategory Id
     * @param  Request $request New ContentCategory data
     *
     * @return object/json
     */
    public function updateContentCategory($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description', null),
            'parent_id' => $request->input('parent_id', null),
        ];

        $updated = $this->contentCategoryRepo->update($data, $id);
        if (!$updated) {
            return response(['message' => 'Couldn\'t update the ContentCategory'], 400);
        }
        return $updated;
    }

    /**
     * Action for DELETE /v1/contentCategories/{id}
     * Delete a contentCategory
     *
     * @param  int $id ContentCategory Id
     *
     * @return object/json
     */
    public function deleteContentCategory($id)
    {
        $deleted = $this->contentCategoryRepo->delete($id);
        if (!$deleted) {
            return response(['message' => 'Couldn\'t delete the ContentCategory'], 400);
        }
        return $deleted;
    }

    /**
     * Action for POST /v1/contentCategories/{id}/move
     * Move a contentCategory right after another contentCategory
     *
     * @param  int  $id      ContentCategory Id
     * @param  Request $request New ContentCategory Data
     *
     * @return object/json
     */
    public function moveContentCategory($id, Request $request)
    {
        $priorSiblingId = $request->input('prior_sibling_id', '');
        $moved = $this->contentCategoryRepo->move($id, $priorSiblingId);
        if (!$moved) {
            return response(['message' => 'Couldn\'t move the ContentCategory'], 400);
        }
        return $moved;
    }
}
