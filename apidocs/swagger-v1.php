<?php
/**
 * @SWG\Swagger(
 *      schemes={"http"},
 *      host=API_HOST,
 *      basePath="/",
 *      @SWG\Info(
 *          version="1.0.0",
 *          title="Api Document",
 *          termsOfService="",
 *      ),
 *      @SWG\SecurityScheme(
 *          name="Authorization",
 *          type="apiKey",
 *          in="header",
 *          securityDefinition="bearerAuth",
 *          description="Bearer Token",
 *      ),
 *      @SWG\Definition(
 *          definition="SuccessResponse",
 *          required={"status", "message", "data"},
 *          type="object",
 *          @SWG\Xml(name="SuccessResponse"),
 *          @SWG\Property(type="string", property="status", description="success"),
 *          @SWG\Property(type="string", property="message", description="message"),
 *          @SWG\Property(type="object", property="data", description="data response"),
 *      ),
 *      @SWG\Definition(
 *          definition="ValidateResponse",
 *          required={"message", "error"},
 *          type="object",
 *          @SWG\Xml(name="ValidateResponse"),
 *          @SWG\Property(type="string", property="message", description="message"),
 *          @SWG\Property(type="object", property="error", description="error response"),
 *      ),
 *      @SWG\Definition(
 *          definition="UnauthorizedResponse",
 *          required={"status", "message", "data"},
 *          type="object",
 *          @SWG\Xml(name="UnauthorizedResponse"),
 *          @SWG\Property(type="string", property="status", description="status"),
 *          @SWG\Property(type="string", property="message", description="message"),
 *          @SWG\Property(type="object", property="data", description="data response"),
 *      ),
 * )
 * 
 * @SWG\Tag(name="Authencation")
 * 
 * @SWG\Post(
 *     path="/auth/login",
 *     description="Login",
 *     summary="Login",
 *     tags={"Authencation"},
 *    @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/auth/register",
 *     description="Register",
 *     summary="Register",
 *     tags={"Authencation"},
 *    @SWG\Parameter(
 *         name="first_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/auth/reset-email",
 *     description="Reset Email",
 *     summary="Reset Email",
 *     tags={"Authencation"},
 *    @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Tag(name="Staff")
 * 
 * @SWG\Post(
 *     path="/staff/list",
 *     description="Staff List",
 *     summary="Staff List",
 *     tags={"Staff"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *          name="body",
 *          in="body",
 *          required=true,
 *          @SWG\Schema(
 *              @SWG\Property(
 *                  property="start", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="length", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="search", 
 *                  type="object", 
 *                  collectionFormat="multi",
 *                  example={"value": ""},
 *              ),
 *              @SWG\Property(
 *                  property="order", 
 *                  type="array", 
 *                  collectionFormat="multi",
 *                  @SWG\Items(
 *                      type="object",
 *                      example={"column": "", "dir": ""},
 *                  ),
 *              ),
 *              @SWG\Property(
 *                  property="columns", 
 *                  type="object", 
 *                  example={"data": ""},
 *              ),
 *              @SWG\Property(
 *                  property="draw", 
 *                  type="string", 
 *                  example="",
 *              ),
 *          ),
 *    ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/staff/save",
 *     description="Staff Save",
 *     summary="Staff Save",
 *     tags={"Staff"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *         name="first_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="last_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="biography",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="website_url",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="account_type",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/staff/update",
 *     description="Staff Update",
 *     summary="Staff Update",
 *     tags={"Staff"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *         name="_id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="first_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="last_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="email",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="account_type",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="biography",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Parameter(
 *         name="website_url",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/staff/delete",
 *     description="Staff Delete",
 *     summary="Staff Delete",
 *     tags={"Staff"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Tag(name="Customers")
 * 
 * @SWG\Post(
 *     path="/customers/list",
 *     description="Customers List",
 *     summary="Customers List",
 *     tags={"Customers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *          name="body",
 *          in="body",
 *          required=true,
 *          @SWG\Schema(
 *              @SWG\Property(
 *                  property="start", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="length", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="search", 
 *                  type="object", 
 *                  collectionFormat="multi",
 *                  example={"value": ""},
 *              ),
 *              @SWG\Property(
 *                  property="order", 
 *                  type="array", 
 *                  collectionFormat="multi",
 *                  @SWG\Items(
 *                      type="object",
 *                      example={"column": "", "dir": ""},
 *                  ),
 *              ),
 *              @SWG\Property(
 *                  property="columns", 
 *                  type="object", 
 *                  example={"data": ""},
 *              ),
 *              @SWG\Property(
 *                  property="draw", 
 *                  type="string", 
 *                  example="",
 *              ),
 *          ),
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/customers/create",
 *      description="Customers Create",
 *      summary="Customers Create",
 *      tags={"Customers"},
 *      security={{
 *          "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="name",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="email",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="password",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="contact_number",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="website_url",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/customers/settings",
 *      description="Customers Settings",
 *      summary="Customers Settings",
 *      tags={"Customers"},
 *      security={{
 *          "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="customer_id",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="push_notification",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="email",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="text_message",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="low_balance",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="new_charger_added",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="fully_charged",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="charging_intrupted",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="ship_to_address",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="address_1",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="address_2",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="city",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="postalcode",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="state",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="country",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="charging_level",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="access_level",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/customers/delete",
 *     description="Customers Delete",
 *     summary="Customers Delete",
 *     tags={"Customers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Tag(name="Chargers")
 * 
 * @SWG\Post(
 *     path="/chargers/list",
 *     description="Chargers List",
 *     summary="Chargers List",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *          name="body",
 *          in="body",
 *          required=true,
 *          @SWG\Schema(
 *              @SWG\Property(
 *                  property="start", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="length", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="search", 
 *                  type="object", 
 *                  collectionFormat="multi",
 *                  example={"value": ""},
 *              ),
 *              @SWG\Property(
 *                  property="order", 
 *                  type="array", 
 *                  collectionFormat="multi",
 *                  @SWG\Items(
 *                      type="object",
 *                      example={"column": "", "dir": ""},
 *                  ),
 *              ),
 *              @SWG\Property(
 *                  property="columns", 
 *                  type="object", 
 *                  example={"data": ""},
 *              ),
 *              @SWG\Property(
 *                  property="draw", 
 *                  type="string", 
 *                  example="",
 *              ),
 *          ),
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/chargers/history-list",
 *     description="Chargers History List",
 *     summary="Chargers History List",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *          name="body",
 *          in="body",
 *          required=true,
 *          @SWG\Schema(
 *              @SWG\Property(
 *                  property="start", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="length", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="search", 
 *                  type="object", 
 *                  collectionFormat="multi",
 *                  example={"value": ""},
 *              ),
 *              @SWG\Property(
 *                  property="order", 
 *                  type="array", 
 *                  collectionFormat="multi",
 *                  @SWG\Items(
 *                      type="object",
 *                      example={"column": "", "dir": ""},
 *                  ),
 *              ),
 *              @SWG\Property(
 *                  property="columns", 
 *                  type="object", 
 *                  example={"data": ""},
 *              ),
 *              @SWG\Property(
 *                  property="draw", 
 *                  type="string", 
 *                  example="",
 *              ),
 *          ),
 *      ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/chargers/add",
 *     description="Chargers Create",
 *     summary="Chargers Create",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="charger_id",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="latitude",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="longitude",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="usage_type",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="connector_type",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="operator",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="cost",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="charging_level",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="access_level",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="status",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="service_time",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *     path="/chargers/update",
 *     description="Chargers Update",
 *     summary="Chargers Update",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="_id",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="charger_id",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="latitude",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="longitude",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="usage_type",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="connector_type",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="operator",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="cost",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="charging_level",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="access_level",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="status",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="service_time",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *     path="/chargers/delete",
 *     description="Chargers Delete",
 *     summary="Chargers Delete",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *     path="/chargers/filters-list",
 *     description="Chargers Filters List",
 *     summary="Chargers Filters List",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Parameter(
 *          name="body",
 *          in="body",
 *          required=true,
 *          @SWG\Schema(
 *              @SWG\Property(
 *                  property="start", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="length", 
 *                  type="number", 
 *                  example=1
 *              ),
 *              @SWG\Property(
 *                  property="search", 
 *                  type="object", 
 *                  collectionFormat="multi",
 *                  example={"value": ""},
 *              ),
 *              @SWG\Property(
 *                  property="order", 
 *                  type="array", 
 *                  collectionFormat="multi",
 *                  @SWG\Items(
 *                      type="object",
 *                      example={"column": "", "dir": ""},
 *                  ),
 *              ),
 *              @SWG\Property(
 *                  property="columns", 
 *                  type="object", 
 *                  example={"data": ""},
 *              ),
 *              @SWG\Property(
 *                  property="draw", 
 *                  type="string", 
 *                  example="",
 *              ),
 *          ),
 *      ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *     path="/chargers/delete-filter",
 *     description="Chargers Delete Filter",
 *     summary="Chargers Delete Filter",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *     path="/chargers/filters",
 *     description="Chargers Add Filter",
 *     summary="Chargers Add Filter",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *    @SWG\Parameter(
 *         name="_id",
 *         in="query",
 *         type="number",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="filter_name",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *    @SWG\Parameter(
 *         name="filter_type",
 *         in="query",
 *         type="string",
 *         required=true,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *     path="/chargers/filters",
 *     description="Chargers Get Filter",
 *     summary="Chargers Get Filter",
 *     tags={"Chargers"},
 *     security={{
 *       "bearerAuth":{}
 *     }},
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/chargers/delete-history",
 *      description="Chargers Delete History",
 *      summary="Chargers Delete History",
 *      tags={"Chargers"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="id",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 */