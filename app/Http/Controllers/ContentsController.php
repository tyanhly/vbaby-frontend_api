<?php

namespace App\Http\Controllers;

use App\Repositories\ContentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentsController extends Controller
{
    /**
     * @var ContentRepository
     */
    private $contentRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentRepository $contentRepo)
    {
        // Construct
        $this->contentRepo = $contentRepo;
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
            'message' => 'Hello from Content API Index',
        ];
        return new JsonResponse($response, 200);
    }

    /**
     * Action for route GET /v1/contents/
     * Get all content from database
     *
     * @return array
     */
    public function indexContents()
    {
        return $this->contentRepo->all();
    }

    /**
     * Action for route GET /v1/contents/{id}
     * Get only one content by its id
     *
     * @param  int $id Content Id
     *
     * @return object
     */
    public function viewContent($id)
    {
        return $this->contentRepo->with(['category'])->find($id);
    }

    /**
     * Action for route POST /v1/contents
     *
     * @param  Request $request New Content data
     *
     * @return object/json
     */
    public function createContent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:16'
        ]);

        $data = [
            'title' => $request->input('title'),
            'due_date' => $request->input('due_date', null),
            'color' => $request->input('color', null),
            'content_groups_id' => $request->input('content_groups_id'),
            'marked' => $request->input('marked', 0)
        ];

        $created = $this->contentRepo->create($data);
        if (!$created) {
            return response(['message' => 'Couldn\'t create Content'], 400);
        }
        return $created;
    }

    /**
     * Action for PUT /v1/contents/{id}
     * Update a content
     *
     * @param  int  $id      Content Id
     * @param  Request $request New Content data
     *
     * @return object/json
     */
    public function updateContent($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:16'
        ]);

        $data = [
            'title' => $request->input('title'),
            'due_date' => $request->input('due_date', null),
            'color' => $request->input('color', null),
            'marked' => $request->input('marked', 0)
        ];

        $updated = $this->contentRepo->update($data, $id);
        if (!$updated) {
            return response(['message' => 'Couldn\'t update the Content'], 400);
        }
        return $updated;
    }

    /**
     * Action for DELETE /v1/contents/{id}
     * Delete a content
     *
     * @param  int $id Content Id
     *
     * @return object/json
     */
    public function deleteContent($id)
    {
        $deleted = $this->contentRepo->delete($id);
        if (!$deleted) {
            return response(['message' => 'Couldn\'t delete the Content'], 400);
        }
        return $deleted;
    }

    /**
     * Action for POST /v1/contents/{id}/move
     * Move a content right after another content
     *
     * @param  int  $id      Content Id
     * @param  Request $request New Content Data
     *
     * @return object/json
     */
    public function moveContent($id, Request $request)
    {
        $priorSiblingId = $request->input('prior_sibling_id', '');
        $moved = $this->contentRepo->move($id, $priorSiblingId);
        if (!$moved) {
            return response(['message' => 'Couldn\'t move the Content'], 400);
        }
        return $moved;
    }
}
