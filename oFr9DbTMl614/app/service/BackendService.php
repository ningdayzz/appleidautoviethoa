<?php
declare (strict_types=1);

namespace app\service;

use Exception;
use think\Service;

class BackendService extends Service
{
    public function register(): void
    {
        $this->app->bind('backendService', BackendService::class);
    }

    public function addTask($id): array
    {
        $backendUrl = env('backend.api_url');
        $backendToken = env('backend.token');
        return $this->setCurl($backendUrl, $backendToken, "addTask", $id);
    }

    public function setCurl(string $backendUrl, string $backendToken, $operation, $id): array
    {
        if (!env('backend.enable_api')) return ["status" => true, "msg" => "Giao diện phụ trợ không được kích hoạt"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $backendUrl . "/$operation");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["token: $backendToken"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ["id" => $id]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!$result || $error || $httpCode != 200)
            return ["status" => false, "msg" => "Ngoại lệ giao diện phụ trợ"];
        else {
            try {
                $result = json_decode($result, true);
                if (!$result["status"])
                    return ["status" => false, "msg" => $result["msg"]];
                else
                    return ["status" => true, "msg" => $result["msg"]];
            } catch (Exception $e) {
                return ["status" => false, "msg" => "Ngoại lệ giao diện phụ trợ"];
            }
        }
    }

    public function restartTask($id): array
    {
        $backendUrl = env('backend.api_url');
        $backendToken = env('backend.token');
        return $this->setCurl($backendUrl, $backendToken, "restartTask", $id);
    }

    public function removeTask($id): array
    {
        $backendUrl = env('backend.api_url');
        $backendToken = env('backend.token');
        return $this->setCurl($backendUrl, $backendToken, "removeTask", $id);
    }
}
