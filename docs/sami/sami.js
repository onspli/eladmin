
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Onspli" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli.html">Onspli</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin.html">Eladmin</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Auth" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Auth.html">Auth</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Auth_AuthInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Auth/AuthInterface.html">AuthInterface</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Auth_Password" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Auth/Password.html">Password</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Auth_User" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Auth/User.html">User</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Exception" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Exception_BadRequestException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/BadRequestException.html">BadRequestException</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Exception_Exception" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/Exception.html">Exception</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Exception_UnauthorizedException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/UnauthorizedException.html">UnauthorizedException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Module" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Module.html">Module</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Module_Crud" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Module/Crud.html">Crud</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Module_Crud_Crud" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Onspli/Eladmin/Module/Crud/Crud.html">Crud</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Module_Eloquent" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Module/Eloquent.html">Eloquent</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Module_Eloquent_Chainset" >                    <div style="padding-left:72px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Module/Eloquent/Chainset.html">Chainset</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Module_Eloquent_Chainset_Action" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Module/Eloquent/Chainset/Action.html">Action</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Module_Eloquent_Chainset_Column" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Module/Eloquent/Chainset/Column.html">Column</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Module_Eloquent_Chainset_Filter" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Module/Eloquent/Chainset/Filter.html">Filter</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Onspli_Eladmin_Module_Eloquent_Crud" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Onspli/Eladmin/Module/Eloquent/Crud.html">Crud</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="class:Onspli_Eladmin_Chainset" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/Chainset.html">Chainset</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Eladmin" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/Eladmin.html">Eladmin</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Module" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/Module.html">Module</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Onspli.html", "name": "Onspli", "doc": "Namespace Onspli"},{"type": "Namespace", "link": "Onspli/Eladmin.html", "name": "Onspli\\Eladmin", "doc": "Namespace Onspli\\Eladmin"},{"type": "Namespace", "link": "Onspli/Eladmin/Auth.html", "name": "Onspli\\Eladmin\\Auth", "doc": "Namespace Onspli\\Eladmin\\Auth"},{"type": "Namespace", "link": "Onspli/Eladmin/Exception.html", "name": "Onspli\\Eladmin\\Exception", "doc": "Namespace Onspli\\Eladmin\\Exception"},{"type": "Namespace", "link": "Onspli/Eladmin/Module.html", "name": "Onspli\\Eladmin\\Module", "doc": "Namespace Onspli\\Eladmin\\Module"},{"type": "Namespace", "link": "Onspli/Eladmin/Module/Crud.html", "name": "Onspli\\Eladmin\\Module\\Crud", "doc": "Namespace Onspli\\Eladmin\\Module\\Crud"},{"type": "Namespace", "link": "Onspli/Eladmin/Module/Eloquent.html", "name": "Onspli\\Eladmin\\Module\\Eloquent", "doc": "Namespace Onspli\\Eladmin\\Module\\Eloquent"},{"type": "Namespace", "link": "Onspli/Eladmin/Module/Eloquent/Chainset.html", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset", "doc": "Namespace Onspli\\Eladmin\\Module\\Eloquent\\Chainset"},
            {"type": "Interface", "fromName": "Onspli\\Eladmin\\Auth", "fromLink": "Onspli/Eladmin/Auth.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html", "name": "Onspli\\Eladmin\\Auth\\AuthInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLoginFields", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLoginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaUnauthorized", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaUnauthorized", "doc": "&quot;This method is called when user is not autorized and elaLoginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLogin", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLogin", "doc": "&quot;Eladmin calls this method during authentication. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAccountFields", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAccountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAccount", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAccount", "doc": "&quot;Eladmin calls this method during profile update. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLogout", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLogout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAuthorize", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAuthorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaUserName", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaUserName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
            
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Auth", "fromLink": "Onspli/Eladmin/Auth.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html", "name": "Onspli\\Eladmin\\Auth\\AuthInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLoginFields", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLoginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaUnauthorized", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaUnauthorized", "doc": "&quot;This method is called when user is not autorized and elaLoginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLogin", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLogin", "doc": "&quot;Eladmin calls this method during authentication. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAccountFields", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAccountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAccount", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAccount", "doc": "&quot;Eladmin calls this method during profile update. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaLogout", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaLogout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaAuthorize", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaAuthorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\AuthInterface", "fromLink": "Onspli/Eladmin/Auth/AuthInterface.html", "link": "Onspli/Eladmin/Auth/AuthInterface.html#method_elaUserName", "name": "Onspli\\Eladmin\\Auth\\AuthInterface::elaUserName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Auth", "fromLink": "Onspli/Eladmin/Auth.html", "link": "Onspli/Eladmin/Auth/Password.html", "name": "Onspli\\Eladmin\\Auth\\Password", "doc": "&quot;Simple username\/password authorization.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method___construct", "name": "Onspli\\Eladmin\\Auth\\Password::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaLoginFields", "name": "Onspli\\Eladmin\\Auth\\Password::elaLoginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaUnauthorized", "name": "Onspli\\Eladmin\\Auth\\Password::elaUnauthorized", "doc": "&quot;This method is called when user is not autorized and elaLoginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaLogin", "name": "Onspli\\Eladmin\\Auth\\Password::elaLogin", "doc": "&quot;Eladmin calls this method during authentication. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaLogout", "name": "Onspli\\Eladmin\\Auth\\Password::elaLogout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaAuthorize", "name": "Onspli\\Eladmin\\Auth\\Password::elaAuthorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaUserName", "name": "Onspli\\Eladmin\\Auth\\Password::elaUserName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaAccountFields", "name": "Onspli\\Eladmin\\Auth\\Password::elaAccountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_elaAccount", "name": "Onspli\\Eladmin\\Auth\\Password::elaAccount", "doc": "&quot;Eladmin calls this method during profile update. Login Fields are passed through POST variable&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Auth", "fromLink": "Onspli/Eladmin/Auth.html", "link": "Onspli/Eladmin/Auth/User.html", "name": "Onspli\\Eladmin\\Auth\\User", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method___construct", "name": "Onspli\\Eladmin\\Auth\\User::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_createTable", "name": "Onspli\\Eladmin\\Auth\\User::createTable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_setPasswordhashAttribute", "name": "Onspli\\Eladmin\\Auth\\User::setPasswordhashAttribute", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaLoginFields", "name": "Onspli\\Eladmin\\Auth\\User::elaLoginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaColumns", "name": "Onspli\\Eladmin\\Auth\\User::elaColumns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaLogin", "name": "Onspli\\Eladmin\\Auth\\User::elaLogin", "doc": "&quot;Eladmin calls this method during authentication. Login Fields are passed through POST variable&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaLogout", "name": "Onspli\\Eladmin\\Auth\\User::elaLogout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaAuthorize", "name": "Onspli\\Eladmin\\Auth\\User::elaAuthorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_get", "name": "Onspli\\Eladmin\\Auth\\User::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaUserName", "name": "Onspli\\Eladmin\\Auth\\User::elaUserName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaUserId", "name": "Onspli\\Eladmin\\Auth\\User::elaUserId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaAccountFields", "name": "Onspli\\Eladmin\\Auth\\User::elaAccountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaActionDelete", "name": "Onspli\\Eladmin\\Auth\\User::elaActionDelete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\User", "fromLink": "Onspli/Eladmin/Auth/User.html", "link": "Onspli/Eladmin/Auth/User.html#method_elaAccount", "name": "Onspli\\Eladmin\\Auth\\User::elaAccount", "doc": "&quot;Eladmin calls this method during profile update. Login Fields are passed through POST variable&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/Chainset.html", "name": "Onspli\\Eladmin\\Chainset", "doc": "&quot;Chainset object is funny method to configure things.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method___isset", "name": "Onspli\\Eladmin\\Chainset::__isset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__cut_child", "name": "Onspli\\Eladmin\\Chainset::_cut_child", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method___unset", "name": "Onspli\\Eladmin\\Chainset::__unset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method___get", "name": "Onspli\\Eladmin\\Chainset::__get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_first", "name": "Onspli\\Eladmin\\Chainset::_set_first", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_first", "name": "Onspli\\Eladmin\\Chainset::_get_first", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_last", "name": "Onspli\\Eladmin\\Chainset::_set_last", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_last", "name": "Onspli\\Eladmin\\Chainset::_get_last", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_current", "name": "Onspli\\Eladmin\\Chainset::current", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_key", "name": "Onspli\\Eladmin\\Chainset::key", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_next", "name": "Onspli\\Eladmin\\Chainset::next", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_rewind", "name": "Onspli\\Eladmin\\Chainset::rewind", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_valid", "name": "Onspli\\Eladmin\\Chainset::valid", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method___call", "name": "Onspli\\Eladmin\\Chainset::__call", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_key", "name": "Onspli\\Eladmin\\Chainset::_set_key", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_key", "name": "Onspli\\Eladmin\\Chainset::_get_key", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_next", "name": "Onspli\\Eladmin\\Chainset::_set_next", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_next", "name": "Onspli\\Eladmin\\Chainset::_get_next", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_prev", "name": "Onspli\\Eladmin\\Chainset::_set_prev", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_prev", "name": "Onspli\\Eladmin\\Chainset::_get_prev", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__set_parent", "name": "Onspli\\Eladmin\\Chainset::_set_parent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method__get_parent", "name": "Onspli\\Eladmin\\Chainset::_get_parent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_before", "name": "Onspli\\Eladmin\\Chainset::before", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset.html#method_after", "name": "Onspli\\Eladmin\\Chainset::after", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html", "name": "Onspli\\Eladmin\\Eladmin", "doc": "&quot;Eladmin core class.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method___construct", "name": "Onspli\\Eladmin\\Eladmin::__construct", "doc": "&quot;Initialize Eladmin.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_run", "name": "Onspli\\Eladmin\\Eladmin::run", "doc": "&quot;Run Eladmin. It&#039;s just a wrapper of method runNoCatch catching exceptions.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_runNoCatch", "name": "Onspli\\Eladmin\\Eladmin::runNoCatch", "doc": "&quot;Run Eladmin. The main function which processes the requests.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_title", "name": "Onspli\\Eladmin\\Eladmin::title", "doc": "&quot;Return administration title to show it in templates.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_version", "name": "Onspli\\Eladmin\\Eladmin::version", "doc": "&quot;Get eladmin version.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_username", "name": "Onspli\\Eladmin\\Eladmin::username", "doc": "&quot;Returns username to show it in templates. Returns null if authorization is off.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_user", "name": "Onspli\\Eladmin\\Eladmin::user", "doc": "&quot;Return authorization instance.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elakey", "name": "Onspli\\Eladmin\\Eladmin::elakey", "doc": "&quot;Eladmins elakey - empty string&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_actionkey", "name": "Onspli\\Eladmin\\Eladmin::actionkey", "doc": "&quot;Return requested action key, null if no action requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_modulekey", "name": "Onspli\\Eladmin\\Eladmin::modulekey", "doc": "&quot;Return requested module key, null if no module requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_CSRFToken", "name": "Onspli\\Eladmin\\Eladmin::CSRFToken", "doc": "&quot;Generate CSRF token&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_request", "name": "Onspli\\Eladmin\\Eladmin::request", "doc": "&quot;Create request url.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_asset", "name": "Onspli\\Eladmin\\Eladmin::asset", "doc": "&quot;Create asset url, file path relative to \/assets directory. Default $version = time()&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_assetpath", "name": "Onspli\\Eladmin\\Eladmin::assetpath", "doc": "&quot;Return requested asset path, null if no asset requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_module", "name": "Onspli\\Eladmin\\Eladmin::module", "doc": "&quot;Return module instance or null if not authorized. Default $key = modulekey()&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_firstAuthorizedModuleKey", "name": "Onspli\\Eladmin\\Eladmin::firstAuthorizedModuleKey", "doc": "&quot;return first authorized module key&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_moduleToElakey", "name": "Onspli\\Eladmin\\Eladmin::moduleToElakey", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_auth", "name": "Onspli\\Eladmin\\Eladmin::auth", "doc": "&quot;Returns true if user is authorized.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_blade", "name": "Onspli\\Eladmin\\Eladmin::blade", "doc": "&quot;Return an instance of Blade.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_views", "name": "Onspli\\Eladmin\\Eladmin::views", "doc": "&quot;Extends array of directories of views and assets&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_view", "name": "Onspli\\Eladmin\\Eladmin::view", "doc": "&quot;Return rendered view. Passes $args and instance of eladmin as $eladmin to the template.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_accountFields", "name": "Onspli\\Eladmin\\Eladmin::accountFields", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_modules", "name": "Onspli\\Eladmin\\Eladmin::modules", "doc": "&quot;Return instances of all authorized modules.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_isModule", "name": "Onspli\\Eladmin\\Eladmin::isModule", "doc": "&quot;Check if class is eladmin module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_isAjaxRequest", "name": "Onspli\\Eladmin\\Eladmin::isAjaxRequest", "doc": "&quot;Check if eladmin was run with ajax request.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_redirect", "name": "Onspli\\Eladmin\\Eladmin::redirect", "doc": "&quot;Redirect (or exit if ajax request). Default url = home&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_CSRFAuth", "name": "Onspli\\Eladmin\\Eladmin::CSRFAuth", "doc": "&quot;Check if CSRF token is valid&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaActionAccount", "name": "Onspli\\Eladmin\\Eladmin::elaActionAccount", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaActionAccountForm", "name": "Onspli\\Eladmin\\Eladmin::elaActionAccountForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_normalizeActionName", "name": "Onspli\\Eladmin\\Eladmin::normalizeActionName", "doc": "&quot;We want action keys to be case insensitive.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_log", "name": "Onspli\\Eladmin\\Eladmin::log", "doc": "&quot;monolog Logger&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initLocalization", "name": "Onspli\\Eladmin\\Eladmin::initLocalization", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initSessions", "name": "Onspli\\Eladmin\\Eladmin::initSessions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initCache", "name": "Onspli\\Eladmin\\Eladmin::initCache", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initAuthorization", "name": "Onspli\\Eladmin\\Eladmin::initAuthorization", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initAllModules", "name": "Onspli\\Eladmin\\Eladmin::initAllModules", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_initMonolog", "name": "Onspli\\Eladmin\\Eladmin::initMonolog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaTitle", "name": "Onspli\\Eladmin\\Eladmin::elaTitle", "doc": "&quot;override default module elaTitle method&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaOutText", "name": "Onspli\\Eladmin\\Eladmin::elaOutText", "doc": "&quot;Convinient method for plain text output. Sets HTTP header text\/plain and echo $str.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaOutHtml", "name": "Onspli\\Eladmin\\Eladmin::elaOutHtml", "doc": "&quot;Convinient method for html output. Sets HTTP header text\/html and echo $str.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Eladmin", "fromLink": "Onspli/Eladmin/Eladmin.html", "link": "Onspli/Eladmin/Eladmin.html#method_elaOutJson", "name": "Onspli\\Eladmin\\Eladmin::elaOutJson", "doc": "&quot;Convinient method for json output. Sets HTTP header application\/json and echo serialized $json.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/BadRequestException.html", "name": "Onspli\\Eladmin\\Exception\\BadRequestException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\BadRequestException", "fromLink": "Onspli/Eladmin/Exception/BadRequestException.html", "link": "Onspli/Eladmin/Exception/BadRequestException.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\BadRequestException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/Exception.html", "name": "Onspli\\Eladmin\\Exception\\Exception", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\Exception", "fromLink": "Onspli/Eladmin/Exception/Exception.html", "link": "Onspli/Eladmin/Exception/Exception.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\Exception::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/UnauthorizedException.html", "name": "Onspli\\Eladmin\\Exception\\UnauthorizedException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\UnauthorizedException", "fromLink": "Onspli/Eladmin/Exception/UnauthorizedException.html", "link": "Onspli/Eladmin/Exception/UnauthorizedException.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\UnauthorizedException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Trait", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/Module.html", "name": "Onspli\\Eladmin\\Module", "doc": "&quot;General Eladmin Module.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaInit", "name": "Onspli\\Eladmin\\Module::elaInit", "doc": "&quot;Each module has to be initialized with eladmin instance and its own elakey.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaInitCheck", "name": "Onspli\\Eladmin\\Module::elaInitCheck", "doc": "&quot;Check if module was initialized. Throws if it wasn&#039;t.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elakey", "name": "Onspli\\Eladmin\\Module::elakey", "doc": "&quot;Each module has its elakey - index in modules array - used to address requests.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaAuth", "name": "Onspli\\Eladmin\\Module::elaAuth", "doc": "&quot;Check if user is authorized to do action, or athorized to access module at all.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaTitle", "name": "Onspli\\Eladmin\\Module::elaTitle", "doc": "&quot;Get name of the module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaIcon", "name": "Onspli\\Eladmin\\Module::elaIcon", "doc": "&quot;Get icon of the module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaRequest", "name": "Onspli\\Eladmin\\Module::elaRequest", "doc": "&quot;Return url for this module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaAsset", "name": "Onspli\\Eladmin\\Module::elaAsset", "doc": "&quot;Create asset url, file path relative to \/assets directory. Default $version = time()&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaRoles", "name": "Onspli\\Eladmin\\Module::elaRoles", "doc": "&quot;Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaSetRoles", "name": "Onspli\\Eladmin\\Module::elaSetRoles", "doc": "&quot;Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaInstanceForAction", "name": "Onspli\\Eladmin\\Module::elaInstanceForAction", "doc": "&quot;Actions will be called on instance of this module returned by this method. Default is $this.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaViews", "name": "Onspli\\Eladmin\\Module::elaViews", "doc": "&quot;Extends array of directories of views and assets&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaBlade", "name": "Onspli\\Eladmin\\Module::elaBlade", "doc": "&quot;Return Blade instance&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaView", "name": "Onspli\\Eladmin\\Module::elaView", "doc": "&quot;Return rendered view.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elaFile", "name": "Onspli\\Eladmin\\Module::elaFile", "doc": "&quot;Determinate asset content-type and print it.&quot;"},
            
            {"type": "Trait", "fromName": "Onspli\\Eladmin\\Module\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaInit", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaInit", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_tableExists", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::tableExists", "doc": "&quot;Check if table for the model exists in the database;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_getTableColumns", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::getTableColumns", "doc": "&quot;Get an array of table columns.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_getSchema", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::getSchema", "doc": "&quot;Get schema manager.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaColumnsDef", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaColumnsDef", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionsDef", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionsDef", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaFiltersDef", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaFiltersDef", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaColumns", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaColumns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActions", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaFilters", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaFilters", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionPostForm", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionPostForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionPutForm", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionPutForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaUsesSoftDeletes", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaUsesSoftDeletes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaDisabledColumns", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaDisabledColumns", "doc": "&quot;Returns an array of columns that cannot be edited from crud. (i.e. primary key, automanaged timestamps)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaVisibleColumns", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaVisibleColumns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaRowValuesArray", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaRowValuesArray", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaColumnsConfigArray", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaColumnsConfigArray", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaRowActionsArray", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaRowActionsArray", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaReadQuery", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaReadQuery", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionRead", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionRead", "doc": "&quot;List database entries.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionUpdate", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionUpdate", "doc": "&quot;Edit database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionCreate", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionCreate", "doc": "&quot;Create database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaUpdate", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaUpdate", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionDelete", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionDelete", "doc": "&quot;Delete database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionForceDelete", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionForceDelete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaActionRestore", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaActionRestore", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Module/Crud/Crud.html", "link": "Onspli/Eladmin/Module/Crud/Crud.html#method_elaGetActionInstance", "name": "Onspli\\Eladmin\\Module\\Crud\\Crud::elaGetActionInstance", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method__set_module", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::_set_module", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method__get_module", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::_get_module", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_getName", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::getName", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_evalProperty", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::evalProperty", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_getAction", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::getAction", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_hidden", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::hidden", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_confirm", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::confirm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_auth", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::auth", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_done", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::done", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_bulk", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::bulk", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_nonlistable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::nonlistable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_listable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::listable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_noneditable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::noneditable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_editable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::editable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_danger", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::danger", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_primary", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::primary", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_secondary", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::secondary", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_success", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::success", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Action.html#method_warning", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Action::warning", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_getName", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::getName", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_getValue", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::getValue", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_evalProperty", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::evalProperty", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_raw", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::raw", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_escaped", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::escaped", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_hidden", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::hidden", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_nonlistable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::nonlistable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_listable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::listable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_nonsearchable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::nonsearchable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_searchable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::searchable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_noneditable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::noneditable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_editable", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::editable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_disabled", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::disabled", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_enabled", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::enabled", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_input", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::input", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_textarea", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::textarea", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_select", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::select", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_belongsTo", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::belongsTo", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_format", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::format", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_limit", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::limit", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_get", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_set", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::set", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_datetime", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::datetime", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Column.html#method_validate", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Column::validate", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Filter.html", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Filter", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Filter", "fromLink": "Onspli/Eladmin/Module/Eloquent/Chainset/Filter.html", "link": "Onspli/Eladmin/Module/Eloquent/Chainset/Filter.html#method_select", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Chainset\\Filter::select", "doc": "&quot;&quot;"},
            
            {"type": "Trait", "fromName": "Onspli\\Eladmin\\Module\\Eloquent", "fromLink": "Onspli/Eladmin/Module/Eloquent.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaViewsPrefix", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaViewsPrefix", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaInit", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaInit", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaColumns", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaColumns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActions", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaFilters", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaFilters", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionPostForm", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionPostForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionPutForm", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionPutForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaUsesSoftDeletes", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaUsesSoftDeletes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaDisabledColumns", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaDisabledColumns", "doc": "&quot;Returns an array of columns that cannot be edited from crud. (i.e. primary key, automanaged timestamps)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaVisibleColumns", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaVisibleColumns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionRead", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionRead", "doc": "&quot;List database entries.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionUpdate", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionUpdate", "doc": "&quot;Edit database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionCreate", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionCreate", "doc": "&quot;Create database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaUpdate", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaUpdate", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionDelete", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionDelete", "doc": "&quot;Delete database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionForceDelete", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionForceDelete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaActionRestore", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaActionRestore", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Module/Eloquent/Crud.html", "link": "Onspli/Eladmin/Module/Eloquent/Crud.html#method_elaGetActionInstance", "name": "Onspli\\Eladmin\\Module\\Eloquent\\Crud::elaGetActionInstance", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


