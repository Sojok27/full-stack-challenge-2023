<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Referral extends Model
{
    protected $encryptable = ['reference_no', 'organisation', 'province', 'district', 'city', 'street_address', 'zipcode', 'country', 'gps_location', 'facility_name', 'facility_type', 'provider_name', 'position', 'phone', 'email', 'website', 'pills_available', 'code_to_use', 'type_of_service', 'note', 'womens_evaluation'];
    //

    public static function getCountries()
    {
        return DB::table('referrals')->pluck('country')->unique();
    }

    public static function getCities($country)
    {
        return DB::table('referrals')->where("country", $country)->pluck('city')->unique();
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function columns()
    {
        return Schema::getColumnListing('referrals');
    }
    public function filterData()
    {
        $places = $filterBase = [];
        $columns = Schema::getColumnListing('referrals');
        $places['names'] = $places['cities'] = [];
        foreach ($columns as $column) {
            $filterBase[$column] = $this->pluckAndDecrypt($column);
        }

        $places['names'] = $filterBase['country'];
        foreach ($filterBase['country'] as $country) {
            $places["cities"][$country] = $this->pluckAndDecrypt("city", ["country" => $country]);
        }
        return ["places" => $places, "filterBase" => $filterBase];
    }

    public static function decrypt($encryptedValues)
    {
        return  $encryptedValues->map(function ($encryptedValue) {
            try {
                return decrypt($encryptedValue);
            } catch (\Exception $e) {
                // Handle decryption error (e.g., log, skip, etc.)
                return $encryptedValue;
            }
        });
    }
    /**
     * NOTE: ONLY WORKS WITH = and LIKE %%
     */
    public static function decryptedWhere($datas, array $where)
    {
        $GLOBALS['_wheres'] = [];
        $GLOBALS['results'] = [];
        $GLOBALS['_wheres'][] = $datas->filter(function ($data) use ($where) {
            $count = count($where);
            $c = 0;
            foreach ($where as $key => $value) {
                $c++;
                if (
                    trim($where[$key]) != trim($data[$key]) || !strstr($data[$key], $where[$key])
                    // Yet to be implemented!! 
                    //|| (
                    //     is_numeric($data[$key]) && $data[$key] > $where[$key]
                    // )
                ) {
                    break;
                } else {
                    if ($c == $count)
                        $GLOBALS['results'][] =  $data;
                }
            }
        });

        return [collect($GLOBALS['results'])];
    }

    private function pluckAndDecrypt($column, $where = [])
    {
        if (!empty($where)) {
            $searchColumns = array_add($where, '_column_', $column);
            $encryptedValues = DB::table('referrals')->get();
            $cities = [];
            $GLOBALS['cities'] = [];
            $results = $encryptedValues->filter(function ($encryptedColumns) use ($cities, $column, $where, $searchColumns) {
                $decryptedValues = [];
                try {
                    foreach ($encryptedColumns as $key => $value) {
                        # code...
                        if (in_array($key, array_keys($searchColumns)) || in_array($key, $searchColumns)) {
                            $decryptedValues[$key] = decrypt($value);
                        }
                    }
                    $searchFlip = array_flip($searchColumns);
                    foreach ($searchFlip as $searchKey) {
                        if ($decryptedValues[$searchKey] != $where[$searchKey]) {
                        } else {
                            $GLOBALS['cities'][] = $cities[] = $decryptedValues[$column];
                        }
                    }
                    // return true;
                } catch (\Exception $e) {
                    // Handle decryption error (e.g., log, skip, etc.)
                    return false;
                }
            });
            return array_unique($GLOBALS['cities']);
        } else
            $encryptedValues = DB::table('referrals')->pluck($column)->unique();
        $decryptedValues = $encryptedValues->map(function ($encryptedValue) {
            try {
                return decrypt($encryptedValue);
            } catch (\Exception $e) {
                // Handle decryption error (e.g., log, skip, etc.)
                return $encryptedValue;
            }
        });

        return $decryptedValues->unique()->values();
    }


    public function setReferenceNoAttribute($value)
    {
        $this->attributes['reference_no'] = encrypt($value);
    }

    public function getReferenceNoAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['reference_no'] ?? $value;
        }
    }
    public function setOrganisationAttribute($value)
    {
        $this->attributes['organisation'] = encrypt($value);
    }

    public function getOrganisationAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['reference_no'] ?? $value;
        }
    }
    public function setProvinceAttribute($value)
    {
        $this->attributes['province'] = encrypt($value);
    }

    public function getProvinceAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['province'] ?? $value;
        }
    }
    public function setDistrictAttribute($value)
    {
        $this->attributes['district'] = encrypt($value);
    }

    public function getDistrictAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['district'] ?? $value;
        }
    }
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = encrypt($value);
    }

    public function getCityAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['city'] ?? $value;
        }
    }
    public function setStreetAddressAttribute($value)
    {
        $this->attributes['street_address'] = encrypt($value);
    }

    public function getStreetAddressAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['street_address'] ?? $value;
        }
    }
    public function setZipCodeAttribute($value)
    {
        $this->attributes['zip_code'] = encrypt($value);
    }

    public function getZipCodeAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['zip_code'] ?? $value;
        }
    }
    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = encrypt($value);
    }

    public function getCountryAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['country'] ?? $value;
        }
    }
    public function setGpsLocationAttribute($value)
    {
        $this->attributes['gps_location'] = encrypt($value);
    }

    public function getGpsLocationAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['gps_location'] ?? $value;
        }
    }
    public function setFacilityNameAttribute($value)
    {
        $this->attributes['facility_name'] = encrypt($value);
    }

    public function getFacilityNameAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['facility_name'] ?? $value;
        }
    }
    public function setFacilityTypeAttribute($value)
    {
        $this->attributes['facility_type'] = encrypt($value);
    }

    public function getFacilityTypeAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['facility_type'] ?? $value;
        }
    }
    public function setProviderNameAttribute($value)
    {
        $this->attributes['provider_name'] = encrypt($value);
    }

    public function getProviderNameAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['provider_name'] ?? $value;
        }
    }
    public function setPositionAttribute($value)
    {
        $this->attributes['position'] = encrypt($value);
    }

    public function getPositionAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['position'] ?? $value;
        }
    }
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = encrypt($value);
    }

    public function getPhoneAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['phone'] ?? $value;
        }
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = encrypt($value);
    }

    public function getEmailAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['email'] ?? $value;
        }
    }
    public function setWebsiteAttribute($value)
    {
        $this->attributes['website'] = encrypt($value);
    }

    public function getWebsiteAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['website'] ?? $value;
        }
    }
    public function setPillsAvailableAttribute($value)
    {
        $this->attributes['pills_available'] = encrypt($value);
    }

    public function getPillsAvailableAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['pills_available'] ?? $value;
        }
    }
    public function setCodeToUseAttribute($value)
    {
        $this->attributes['code_to_use'] = encrypt($value);
    }

    public function getCodeToUseAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['code_to_use'] ?? $value;
        }
    }
    public function setTypeOfServiceAttribute($value)
    {
        $this->attributes['type_of_service'] = encrypt($value);
    }

    public function getTypeOfServiceAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['type_of_service'] ?? $value;
        }
    }
    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = encrypt($value);
    }

    public function getNoteAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['note'] ?? $value;
        }
    }
    public function setWomensEvaluationAttribute($value)
    {
        $this->attributes['womens_evaluation'] = encrypt($value);
    }

    public function getWomensEvaluationAttribute($value)
    {
        try {
            $decryptedValue = decrypt($value);
            return $decryptedValue;
        } catch (\Exception $e) {
            // Handle the exception as needed
            return $this["\x00*\x00items"]['womens_evaluation'] ?? $value;
        }
    }
}
