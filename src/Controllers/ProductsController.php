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
class ProductsController extends BaseController
{
    /**
     * @var ProductsController The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     * @return ProductsController The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Returns data about all products.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['userId']     (optional) If supplied, only products owned by the given user will be
     *                                       returned.
     * @param integer $options['filterId']   (optional) ID of the filter to use
     * @param string  $options['firstChar']  (optional) If supplied, only products whose name starts with the specified
     *                                       letter will be returned (case insensitive).
     * @param integer $options['start']      (optional) Pagination start
     * @param integer $options['limit']      (optional) Items shown per page
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getAllProducts(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'user_id'    => $this->val($options, 'userId'),
            'filter_id'  => $this->val($options, 'filterId'),
            'first_char' => $this->val($options, 'firstChar'),
            'start'      => $this->val($options, 'start', 0),
            'limit'      => $this->val($options, 'limit'),
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\Product');
    }


    /**
     * Searches all Products by name, code and/or custom fields. This endpoint is a wrapper of /v1/itemSearch with a narrower OAuth scope.
     *
     * @param  array  $options    Array with all options for search
     * @param string  $options['term']        The search term to look for. Minimum 2 characters (or 1 if using exact_match).
     * @param string  $options['fields']      (optional) A comma-separated string array. The fields to perform the search from. Defaults to all of them.
     * @param bool    $options['exactMatch']  (optional) When enabled, only full exact matches against the given term are returned. It is not case sensitive
     * @param string  $options['includeFields']      (optional) Supports including optional fields in the results which are not provided by default.
     * @param integer $options['start']       (optional) Pagination start. Note that the pagination is based on main results and does not include related items when using search_for_related_items parameter.
     * @param integer $options['limit']       (optional) Items shown per page
     *
     * @return void response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function searchProducts(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/search';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'term'        => $this->val($options, 'term'),
            'fields'  => $this->val($options, 'fields'),
            'exact_match' => $this->val($options, 'exactMatch'),
            'include_fields'   => $this->val($options, 'includeFields'),
            'start'       => $this->val($options, 'start', 0),
            'limit'       => $this->val($options, 'limit'),
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
     * Adds a new product to the products inventory. For more information on how to add a product, see <a
     * href="https://pipedrive.readme.io/docs/adding-a-product" target="_blank" rel="noopener
     * noreferrer">this tutorial</a>.
     *
     * @param object $body (optional) TODO: type description here
     * @return void response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function addAProduct(
        $body = null
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products';

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'content-type'  => 'application/json; charset=utf-8',
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::post($_queryUrl, $_headers, $_bodyJson);

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
     * Marks a product as deleted.
     *
     * @param integer $id ID of the product
     * @return void response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function deleteAProduct(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}';

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
     * Returns data about a specific product.
     *
     * @param integer $id ID of the product
     * @return void response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getOneProduct(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}';

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
     * Updates product data.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['id']          ID of the product
     * @param string  $options['name']        (optional) Name of the product.
     * @param string  $options['code']        (optional) Product code.
     * @param string  $options['unit']        (optional) Unit in which this product is sold
     * @param double  $options['tax']         (optional) Tax percentage
     * @param int     $options['activeFlag']  (optional) Whether this product will be made active or not.
     * @param int     $options['visibleTo']   (optional) Visibility of the product. If omitted, visibility will be set
     *                                        to the default visibility setting of this item type for the authorized
     *                                        user.<dl class="fields-list"><dt>1</dt><dd>Owner &amp; followers
     *                                        (private)</dd><dt>3</dt><dd>Entire company (shared)</dd></dl>
     * @param integer $options['ownerId']     (optional) ID of the user who will be marked as the owner of this product.
     *                                        When omitted, the authorized user ID will be used.
     * @param string  $options['prices']      (optional) Array of objects, each containing: currency (string), price
     *                                        (number), cost (number, optional), overhead_cost (number, optional). Note
     *                                        that there can only be one price per product per currency. When 'prices'
     *                                        is omitted altogether, no prices will be set up for the product.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function updateAProduct(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'          => $this->val($options, 'id'),
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //prepare parameters
        $_parameters = array (
            'name'        => $this->val($options, 'name'),
            'code'        => $this->val($options, 'code'),
            'unit'        => $this->val($options, 'unit'),
            'tax'         => $this->val($options, 'tax'),
            'active_flag' => APIHelper::prepareFormFields($this->val($options, 'activeFlag')),
            'visible_to' => APIHelper::prepareFormFields($this->val($options, 'visibleTo')),
            'owner_id'    => $this->val($options, 'ownerId'),
            'prices'      => $this->val($options, 'prices')
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\Product');
    }

    /**
     * Returns data about deals that have a product attached to.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['id']     ID of the product
     * @param integer $options['start']  (optional) Pagination start
     * @param integer $options['limit']  (optional) Items shown per page
     * @param string  $options['status'] (optional) Only fetch deals with specific status. If omitted, all not deleted
     *                                   deals are fetched.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getDealsWhereAProductIsAttachedTo(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/deals';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'     => $this->val($options, 'id'),
            ));

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'start'  => $this->val($options, 'start', 0),
            'limit'  => $this->val($options, 'limit'),
            'status' => $this->val($options, 'status', Models\Status2Enum::ALL_NOT_DELETED),
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\BasicDeal');
    }

    /**
     * Lists files associated with a product.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['id']                    ID of the product
     * @param integer $options['start']                 (optional) Pagination start
     * @param integer $options['limit']                 (optional) Items shown per page
     * @param int     $options['includeDeletedFiles']   (optional) When enabled, the list of files will also include
     *                                                  deleted files. Please note that trying to download these files
     *                                                  will not work.
     * @param string  $options['sort']                  (optional) Field names and sorting mode separated by a comma
     *                                                  (field_name_1 ASC, field_name_2 DESC). Only first-level field
     *                                                  keys are supported (no nested keys). Supported fields: id,
     *                                                  user_id, deal_id, person_id, org_id, product_id, add_time,
     *                                                  update_time, file_name, file_type, file_size, comment.
     * @return void response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function listFilesAttachedToAProduct(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/files';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'                    => $this->val($options, 'id'),
            ));

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'start'                 => $this->val($options, 'start', 0),
            'limit'                 => $this->val($options, 'limit'),
            'include_deleted_files' => $this->val($options, 'includeDeletedFiles'),
            'sort'                  => $this->val($options, 'sort'),
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'          => BaseController::USER_AGENT,
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
     * Lists the followers of a Product
     *
     * @param integer $id ID of the product
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function listFollowersOfAProduct(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/followers';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id' => $id,
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\UserIDs');
    }

    /**
     * Adds a follower to a product.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['id']      ID of the product
     * @param integer $options['userId']  ID of the user
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function addAFollowerToAProduct(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/followers';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'      => $this->val($options, 'id'),
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', Configuration::$oAuthToken->accessToken)
        );

        //prepare parameters
        $_parameters = array (
            'user_id' => $this->val($options, 'userId')
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\NewFollowerResponse');
    }

    /**
     * Deletes a follower from a product.
     *
     * @param  array  $options    Array with all options for search
     * @param integer $options['id']          ID of the product
     * @param integer $options['followerId']  ID of the follower
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function deleteAFollowerFromAProduct(
        $options
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/followers/{follower_id}';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id'          => $this->val($options, 'id'),
            'follower_id' => $this->val($options, 'followerId'),
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\DeleteProductFollowerResponse');
    }

    /**
     * Lists users permitted to access a product.
     *
     * @param integer $id ID of the product
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function listPermittedUsers(
        $id
    ) {
        //check or get oauth token
        OAuthManager::getInstance()->checkAuthorization();

        //prepare query string for API call
        $_queryBuilder = '/products/{id}/permittedUsers';

        //process optional query parameters
        $_queryBuilder = APIHelper::appendUrlWithTemplateParameters($_queryBuilder, array (
            'id' => $id,
            ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
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

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'Pipedrive\\Models\\UserIDs');
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
