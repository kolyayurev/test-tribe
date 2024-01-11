<?php

namespace App\Api\Base\Action;

use App\Api\Base\Exceptions\ApiException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function config;
use function report;
use function response;

abstract class BaseActionAbstract
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const STATUS_SUCCESS = 'success';

    const STATUS_ERROR = 'error';

    /**
     * @var array<string,mixed>
     */
    public array $rules = [];

    /**
     * @var array<string,string>
     */
    public array $messages = [];

    /**
     * @var array<string,mixed>
     */
    protected array $input = [];

    /**
     * @var array<string,mixed>
     */
    protected array $validated = [];

    protected Request $request;

    /**
     * @return array<mixed>|null
     */
    abstract protected function action(): ?array;

    public function handle(Request $request): JsonResponse
    {
        try {
            $this->request = $request;
            $this->input = $request->all();

            $rules = $this->getRules();
            $messages = $this->getMessages();

            $this->validated = $this->validate($request, $rules, $messages);
            $data = $this->action();
        } catch (ApiException $e) {

            return $this->fail($e->getMessage(), $e->getCode());
        } catch (ValidationException $e) {

            $error = $e->errorBag('default')->getMessage();

            return $this->fail($error, 422);
        } catch (\Throwable $e) {

            $error = $e->getMessage().' File:'.$e->getFile().' line:'.$e->getLine();
            report($e);

            $text = config('app.debug') ?
                $error
                :
                __('Internal server error');

            return $this->fail($text, 500);
        }

        return $this->success($data);
    }

    /**
     * @param array<mixed>|null $data
     * @param string $status
     * @param string $text
     * @param int $code
     * @return JsonResponse
     */
    public function response(?array $data, string $status, string $text, int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => $status,
            'message' => $text,
        ], $code);
    }

    /**
     * @param array<mixed>|null $data
     * @return JsonResponse
     */
    public function success(?array $data = null): JsonResponse
    {
        return $this->response($data, self::STATUS_SUCCESS, 'Ok');
    }

    public function fail(string $text, int $code = 500): JsonResponse
    {
        return $this->response(null, self::STATUS_ERROR, $text, $code);
    }


    /**
     * @return array<string,mixed>
     */
    public function getRules(): array
    {
        return $this->rules;
    }
    /**
     * @return array<string,string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
