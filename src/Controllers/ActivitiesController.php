<?php
/*
 * Pipedrive
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace Pipedrive\Controllers;

use Pipedrive\APIException;
use Pipedrive\APIHelper;
use Pipedrive\Configuration;
use Pipedrive\Models;
use Pipedrive\Exceptions;
use Pipedrive\Utils\DateTimeHelper;
use Pipedrive\Http\HttpRequest;
use Pipedrive\Http\HttpResponse;
use Pipedrive\Http\HttpMethod;
use Pipedrive\Http\HttpContext;
use Pipedrive\OAuthManager;
use Pipedrive\Servers;
use Pipedrive\Utils\CamelCaseHelper;
use Unirest\Request;

/**
 * @todo Add a general description for this controller.
 */
class ActivitiesController extends BaseController
{
    /**
     * @var ActivitiesController The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     * @return ActivitiesController The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Marks multiple activities as deleted.
     *
     * @param string $ids Comma-separated IDs that will be deleted
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function deleteMultipleActivitiesInBulk(
        $ids
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'ids' => $ids,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::DELETE, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::delete($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }

    /**
     * Returns all activities assigned to a particular user.
     *
     * @param  array  $options    Array with all options for search
     * @param integer  $options['userId']     (optional) ID of the user whose activities will be fetched. If omitted,
     *                                        the user associated with the API token will be used. If 0, activities for
     *                                        all company users will be fetched based on the permission sets.
     * @param integer  $options['filterId']   (optional) ID of the filter to use (will narrow down results if used
     *                                        together with user_id parameter).
     * @param string   $options['type']       (optional) Type of the activity, can be one type or multiple types
     *                                        separated by a comma. This is in correlation with the key_string
     *                                        parameter of ActivityTypes.
     * @param integer  $options['start']      (optional) Pagination start
     * @param integer  $options['limit']      (optional) Items shown per page
     * @param DateTime $options['startDate']  (optional) Date in format of YYYY-MM-DD from which activities to fetch
     *                                        from.
     * @param DateTime $options['endDate']    (optional) Date in format of YYYY-MM-DD until which activities to fetch
     *                                        to.
     * @param int      $options['done']       (optional) Whether the activity is done or not. 0 = Not done, 1 = Done.
     *                                        If omitted returns both Done and Not done activities.
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getAllActivitiesAssignedToAParticularUser(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'user_id'    => $this->val($options, 'userId'),
            'filter_id'  => $this->val($options, 'filterId'),
            'type'       => $this->val($options, 'type'),
            'start'      => $this->val($options, 'start', 0),
            'limit'      => $this->val($options, 'limit'),
            'start_date' => DateTimeHelper::toSimpleDate($this->val($options, 'startDate')),
            'end_date'   => DateTimeHelper::toSimpleDate($this->val($options, 'endDate')),
            'done'       => $this->val($options, 'done'),
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }

    /**
     * Adds a new activity. Includes more_activities_scheduled_in_context property in response's
     * additional_data which indicates whether there are more undone activities scheduled with the same
     * deal, person or organization (depending on the supplied data). For more information on how to add an
     * activity, see <a href="https://pipedrive.readme.io/docs/adding-an-activity" target="_blank"
     * rel="noopener noreferrer">this tutorial</a>.
     *
     * @param  array  $options    Array with all options for search
     * @param string   $options['subject']      Subject of the activity
     * @param string   $options['type']         Type of the activity. This is in correlation with the key_string
     *                                          parameter of ActivityTypes.
     * @param int      $options['done']         (optional) TODO: type description here
     * @param DateTime $options['dueDate']      (optional) Due date of the activity. Format: YYYY-MM-DD
     * @param string   $options['dueTime']      (optional) Due time of the activity in UTC. Format: HH:MM
     * @param string   $options['duration']     (optional) Duration of the activity. Format: HH:MM
     * @param integer  $options['userId']       (optional) ID of the user whom the activity will be assigned to. If
     *                                          omitted, the activity will be assigned to the authorized user.
     * @param integer  $options['dealId']       (optional) ID of the deal this activity will be associated with
     * @param integer  $options['personId']     (optional) ID of the person this activity will be associated with
     * @param string   $options['participants'] (optional) List of multiple persons (participants) this activity will
     *                                          be associated with. If omitted, single participant from person_id field
     *                                          is used. It requires a structure as follows: [{"person_id":1,
     *                                          "primary_flag":true}]
     * @param integer  $options['orgId']        (optional) ID of the organization this activity will be associated
     *                                          with
     * @param string   $options['note']         (optional) Note of the activity (HTML format)
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function addAnActivity(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities';

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //prepare parameters
        $_parameters = array (
            'subject'      => $this->val($options, 'subject'),
            'type'         => $this->val($options, 'type'),
            'done'         => APIHelper::prepareFormFields($this->val($options, 'done')),
            'due_date'     => DateTimeHelper::toSimpleDate($this->val($options, 'dueDate')),
            'due_time'     => $this->val($options, 'dueTime'),
            'duration'     => $this->val($options, 'duration'),
            'user_id'      => $this->val($options, 'userId'),
            'deal_id'      => $this->val($options, 'dealId'),
            'person_id'    => $this->val($options, 'personId'),
            'participants' => $this->val($options, 'participants'),
            'org_id'       => $this->val($options, 'orgId'),
            'note'         => $this->val($options, 'note'),
            'busy_flag'    => $this->val($options, 'busyFlag')
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl, $_parameters);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::post($_queryUrl, $_headers, Request\Body::Form($_parameters));

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }

    /**
     * Deletes an activity.
     *
     * @param integer $id ID of the activity
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function deleteAnActivity(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities/{id}';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id' => $id,
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::DELETE, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::delete($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }

    /**
     * Returns details of a specific activity.
     *
     * @param integer $id ID of the activity
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getDetailsOfAnActivity(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities/{id}';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id' => $id,
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);

        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }

    /**
     * Modifies an activity. Includes more_activities_scheduled_in_context property in response's
     * additional_data which indicates whether there are more undone activities scheduled with the same
     * deal, person or organization (depending on the supplied data).
     *
     * @param  array  $options    Array with all options for search
     * @param integer  $options['id']           ID of the activity
     * @param string   $options['subject']      Subject of the activity
     * @param string   $options['type']         Type of the activity. This is in correlation with the key_string
     *                                          parameter of ActivityTypes.
     * @param int      $options['done']         (optional) TODO: type description here
     * @param DateTime $options['dueDate']      (optional) Due date of the activity. Format: YYYY-MM-DD
     * @param string   $options['dueTime']      (optional) Due time of the activity in UTC. Format: HH:MM
     * @param string   $options['duration']     (optional) Duration of the activity. Format: HH:MM
     * @param integer  $options['userId']       (optional) ID of the user whom the activity will be assigned to. If
     *                                          omitted, the activity will be assigned to the authorized user.
     * @param integer  $options['dealId']       (optional) ID of the deal this activity will be associated with
     * @param integer  $options['personId']     (optional) ID of the person this activity will be associated with
     * @param string   $options['participants'] (optional) List of multiple persons (participants) this activity will
     *                                          be associated with. If omitted, single participant from person_id field
     *                                          is used. It requires a structure as follows: [{"person_id":1,
     *                                          "primary_flag":true}]
     * @param integer  $options['orgId']        (optional) ID of the organization this activity will be associated
     *                                          with
     * @param string   $options['note']         (optional) Note of the activity (HTML format)
     * @return \Pipedrive\Utils\JsonSerializer response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function updateEditAnActivity(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/activities/{id}';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'           => $this->val($options, 'id'),
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //prepare parameters
        $_parameters = array (
            'subject'      => $this->val($options, 'subject'),
            'type'         => $this->val($options, 'type'),
            'done'       => APIHelper::prepareFormFields($this->val($options, 'done')),
            'due_date'   => DateTimeHelper::toSimpleDate($this->val($options, 'dueDate')),
            'due_time'     => $this->val($options, 'dueTime'),
            'duration'     => $this->val($options, 'duration'),
            'user_id'      => $this->val($options, 'userId'),
            'deal_id'      => $this->val($options, 'dealId'),
            'person_id'    => $this->val($options, 'personId'),
            'participants' => $this->val($options, 'participants'),
            'org_id'       => $this->val($options, 'orgId'),
            'note'         => $this->val($options, 'note')
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::PUT, $_headers, $_queryUrl, $_parameters);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::put($_queryUrl, $_headers, Request\Body::Form($_parameters));

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        return CamelCaseHelper::keysToCamelCase($response->body);
    }


    /**
    * Array access utility method
     * @param  array          $arr         Array of values to read from
     * @param  string         $key         Key to get the value from the array
     * @param  mixed|null     $default     Default value to use if the key was not found
     * @return mixed
     */
    private function val($arr, $key, $default = null)
    {
        if (isset($arr[$key])) {
            return is_bool($arr[$key]) ? var_export($arr[$key], true) : $arr[$key];
        }
        return $default;
    }
}
