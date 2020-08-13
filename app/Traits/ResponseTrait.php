<?php
namespace App\Traits;

use Log;
use Exception;

trait ResponseTrait
{
    /*
    data:
        查询单条数据时直接返回对象结构，减少数据层级；
        查询列表数据时返回数组结构；
        创建或更新成功，返回修改后的数据；（也可以不返回数据直接返回空对象）
        删除成功时返回空对象
    status:
        error, 客户端（前端）出错，HTTP 状态响应码在 400-599 之间。如，传入错误参数，访问不存在的数据资源等
        fail，服务端（后端）出错，HTTP 状态响应码在 500-599 之间。如，代码语法错误，空对象调用函数，连接数据库失败，undefined index 等
        success, HTTP 响应状态码为 1XX、2XX 和 3XX，用来表示业务处理成功。
    message: 描述执行的请求操作处理的结果；也可以支持国际化，根据实际业务需求来切换。
    */

    // 表示业务处理成功。
    public function successResponse($data, string $message = '', $code = 200) {
        return response()->json([
            "status" => "success",
            "code" => $code,
            "message" => $message,
            "data" => $data
        ], $code);
    }

    // 服务端（后端）出错，如，代码语法错误，空对象调用函数，连接数据库失败，undefined index 等
    public function failResponse($data = null, string $message = 'Service error', $exception = null, $code = 500) {
        if ($exception != null ) {
            if (env("APP_DEBUG") == true) {
                $data = [
                    "message" => $exception->getMessage(),
                    "file" => $exception->getFile(),
                    "line" => $exception->getLine(),
                    "trace" => $exception->getTrace(),
                ];
            }
        }

        return response()->json([
            "status" => "fail",
            "code" => $code,
            "message" => $message,
            "data" => $data
        ], $code);

    }

    // 客户端（前端）出错，如，传入错误参数，访问不存在的数据资源等
    public function errorResponse($data = null, string $message = 'request params validate fail', $code = 400) {
        return response()->json([
            "status" => "error",
            "code" => $code,
            "message" => $message,
            "data" => $data
        ], $code);
    }

}
