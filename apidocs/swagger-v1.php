<?php
/**
 * @SWG\Swagger(
 *      schemes={"https"},
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
 *         required=true,
 *     ),
 *     @SWG\Parameter(
 *         name="contact_number",
 *         in="query",
 *         type="string",
 *         required=false,
 *     ),
 *     @SWG\Response(response="200", description="OK")
 * )
 * 
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
 *      path="/auth/logout",
 *      description="Logout",
 *      summary="Logout",
 *      tags={"Authencation"},
 *      security={{
 *          "bearerAuth":{}
 *      }},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/update-password",
 *      description="Update Password",
 *      summary="Update Password",
 *      tags={"Authencation"},
 *      security={{
 *          "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="current_password",
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
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *      path="/reset-password",
 *      description="Reset Password",
 *      summary="Reset Password",
 *      tags={"Authencation"},
 *      @SWG\Parameter(
 *          name="current_password",
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
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/auth/reset-email",
 *      description="Reset Email",
 *      summary="Reset Email",
 *      tags={"Authencation"},
 *      @SWG\Parameter(
 *          name="email",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Get(
 *      path="/me",
 *      description="Me",
 *      summary="Me",
 *      tags={"Authencation"},
 *      security={{
 *          "bearerAuth":{}
 *      }},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/me",
 *      description="Update profile",
 *      summary="Update profile",
 *      tags={"Authencation"},
 *      security={{
 *       "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="first_name",
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
 *          name="email",
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
 *      @SWG\Parameter(
 *          name="last_name",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Parameter(
 *          name="biography",
 *          in="query",
 *          type="string",
 *          required=false,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/upload-avatar",
 *      description="Upload Avatar",
 *      summary="Upload Avatar",
 *      tags={"Authencation"},
 *      security={{
 *       "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="profile_pic",
 *          in="query",
 *          type="file",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
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
 * @SWG\Tag(name="Payments")
 * 
 * @SWG\Post(
 *      path="/payments/list",
 *      description="Payments List",
 *      summary="Payments List",
 *      tags={"Payments"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
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
 *      path="/payments/delete",
 *      description="Payments Delete",
 *      summary="Payments Delete",
 *      tags={"Payments"},
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
 * @SWG\Tag(name="Vehicles")
 * 
 * @SWG\Post(
 *      path="/vehicles/list",
 *      description="Vehicles List",
 *      summary="Vehicles List",
 *      tags={"Vehicles"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
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
 * 
 * @SWG\Post(
 *      path="/vehicles/registered-list",
 *      description="Vehicles Registered",
 *      summary="Vehicles Registered",
 *      tags={"Vehicles"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
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
 * 
 * @SWG\Post(
 *      path="/vehicles/add",
 *      description="Vehicles Create",
 *      summary="Vehicles Create",
 *      tags={"Vehicles"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="model",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="type",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="year",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *      path="/vehicles/update",
 *      description="Vehicles Update",
 *      summary="Vehicles Update",
 *      tags={"Vehicles"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="_id",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="model",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="type",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="year",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *      path="/vehicles/delete",
 *      description="Vehicles Delete",
 *      summary="Vehicles Delete",
 *      tags={"Vehicles"},
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
 * 
 * @SWG\Post(
 *      path="/vehicles/delete-registered",
 *      description="Vehicles Delete Registered",
 *      summary="Vehicles Delete Registered",
 *      tags={"Vehicles"},
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
 * @SWG\Tag(name="Energy")
 * 
 * 
 * @SWG\Post(
 *      path="/energy/list",
 *      description="Energy List",
 *      summary="Energy List",
 *      tags={"Energy"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
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
 * 
 * @SWG\Post(
 *      path="/energy/settings-list",
 *      description="Energy Setting List",
 *      summary="Energy Setting List",
 *      tags={"Energy"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
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
 * 
 * @SWG\Post(
 *      path="/energy/add",
 *      description="Energy Create",
 *      summary="Energy Create",
 *      tags={"Energy"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="company",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="country",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *      path="/energy/update",
 *      description="Energy Update",
 *      summary="Energy Update",
 *      tags={"Energy"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="_id",
 *          in="query",
 *          type="number",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="company",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="country",
 *          in="query",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * 
 * @SWG\Post(
 *      path="/energy/delete",
 *      description="Energy Delete",
 *      summary="Energy Delete",
 *      tags={"Energy"},
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
 * 
 * @SWG\Post(
 *      path="/energy/delete-settings",
 *      description="Energy Delete Settings",
 *      summary="Energy Delete Settings",
 *      tags={"Energy"},
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
 * @SWG\Tag(name="Export")
 * 
 * @SWG\Post(
 *      path="/export-pdf",
 *      description="Export PDF",
 *      summary="Export PDF",
 *      tags={"Export"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="export_type",
 *          in="query",
 *          type="string",
 *          required=true,
 *          description="value = chargers | vehicles | energy | filters"
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Post(
 *      path="/export-excel",
 *      description="Export Excel",
 *      summary="Export Excel",
 *      tags={"Export"},
 *      security={{
 *        "bearerAuth":{}
 *      }},
 *      @SWG\Parameter(
 *          name="export_type",
 *          in="query",
 *          type="string",
 *          required=true,
 *          description="value = chargers | vehicles | energy | filters"
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/download-pdf/{filename}",
 *      description="Download PDF File",
 *      summary="Download PDF File",
 *      tags={"Export"},
 *      @SWG\Parameter(
 *          name="filename",
 *          in="path",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/download-excel/{filename}",
 *      description="Download Excel File",
 *      summary="Download Excel File",
 *      tags={"Export"},
 *      @SWG\Parameter(
 *          name="filename",
 *          in="path",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Tag(name="Other")
 * 
 * @SWG\Get(
 *      path="/img/{folder}/{image}",
 *      description="Image Link",
 *      summary="Image Link",
 *      tags={"Other"},
 *      @SWG\Parameter(
 *          name="folder",
 *          in="path",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Parameter(
 *          name="image",
 *          in="path",
 *          type="string",
 *          required=true,
 *      ),
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/country-list",
 *      description="Country List",
 *      summary="Country List",
 *      tags={"Other"},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/charger-filters",
 *      description="Charger Filters",
 *      summary="Charger Filters",
 *      tags={"Other"},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/dumy_data",
 *      description="Dumy Data",
 *      summary="Dumy Data",
 *      tags={"Other"},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/update_password",
 *      description="Update Password",
 *      summary="Update Password",
 *      tags={"Other"},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 * @SWG\Get(
 *      path="/testmail",
 *      description="Test Mail",
 *      summary="Test Mail",
 *      tags={"Other"},
 *      @SWG\Response(response="200", description="OK")
 * )
 * 
 */