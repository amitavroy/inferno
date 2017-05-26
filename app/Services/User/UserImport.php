<?php

namespace App\Services\User;

use App\User;
use DB;
use Log;

class UserImport
{
    protected $users = [];
    protected $valid = true;
    protected $errorRows = [];
    protected $validRows = [];

    public function checkImportData($rows, $header)
    {
        $emails = [];

        foreach ($rows as $key => $row) {
            $row = array_combine($header, $row);

            // check for correct email
            if (!$this->checkValidEmail($row['email'])) {
                $row['message'] = 'Invalid email';
                $this->errorRows[$key] = $row;
                $this->valid = false;
            } else {
                $emails[] = $row['email'];
            }
        }

        $exist = $this->checkUserExist($emails);

        if (count($exist) > 0) {
            $this->valid = false;
            $this->addUserExistErrorMessage($exist, $header, $rows);
        }

        return $this->valid;
    }

    public function getErrorRows()
    {
        return $this->errorRows;
    }

    private function checkValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //"Invalid email format";
            return false;
        }
        return true;
    }

    private function checkUserExist($emails)
    {
        return User::whereIn('email', $emails)->get()->pluck('email')->toArray();
    }

    private function addUserExistErrorMessage($exist, $header, $rows)
    {
        foreach ($rows as $key => $row) {
            $row = array_combine($header, $row);
            if (in_array($row['email'], $exist)) {
                $row['message'] = 'Email exists.';
                $this->errorRows[$key] = $row;
            }
        }

        return $rows;
    }

    public function createUsers($header, $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $row) {
                $row = array_combine($header, $row);
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => bcrypt(uniqid()),
                    'active' => 1,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
        }
    }
}