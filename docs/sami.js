
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Onspli" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli.html">Onspli</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin.html">Eladmin</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Auth" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Auth.html">Auth</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Auth_Password" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Auth/Password.html">Password</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Chainset" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Chainset.html">Chainset</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Chainset_Chainset" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Chainset/Chainset.html">Chainset</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Chainset_Child" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Chainset/Child.html">Child</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Exception" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Exception_BadRequestException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/BadRequestException.html">BadRequestException</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Exception_Exception" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/Exception.html">Exception</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Exception_UnauthorizedException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Onspli/Eladmin/Exception/UnauthorizedException.html">UnauthorizedException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Modules" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Modules.html">Modules</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Modules_Crud" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Modules/Crud.html">Crud</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Onspli_Eladmin_Modules_Crud_Chainset" >                    <div style="padding-left:72px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Modules/Crud/Chainset.html">Chainset</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Action" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Action.html">Action</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Actions" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Actions.html">Actions</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Column" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Column.html">Column</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Columns" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Columns.html">Columns</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Filter" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Filter.html">Filter</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Chainset_Filters" >                    <div style="padding-left:98px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Chainset/Filters.html">Filters</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Onspli_Eladmin_Modules_Crud_Crud" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Crud/Crud.html">Crud</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Onspli_Eladmin_Modules_Eloquent" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Onspli/Eladmin/Modules/Eloquent.html">Eloquent</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Onspli_Eladmin_Modules_Eloquent_Crud" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="Onspli/Eladmin/Modules/Eloquent/Crud.html">Crud</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="class:Onspli_Eladmin_Core" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/Core.html">Core</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_IAuth" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/IAuth.html">IAuth</a>                    </div>                </li>                            <li data-name="class:Onspli_Eladmin_Module" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Onspli/Eladmin/Module.html">Module</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Onspli.html", "name": "Onspli", "doc": "Namespace Onspli"},{"type": "Namespace", "link": "Onspli/Eladmin.html", "name": "Onspli\\Eladmin", "doc": "Namespace Onspli\\Eladmin"},{"type": "Namespace", "link": "Onspli/Eladmin/Auth.html", "name": "Onspli\\Eladmin\\Auth", "doc": "Namespace Onspli\\Eladmin\\Auth"},{"type": "Namespace", "link": "Onspli/Eladmin/Chainset.html", "name": "Onspli\\Eladmin\\Chainset", "doc": "Namespace Onspli\\Eladmin\\Chainset"},{"type": "Namespace", "link": "Onspli/Eladmin/Exception.html", "name": "Onspli\\Eladmin\\Exception", "doc": "Namespace Onspli\\Eladmin\\Exception"},{"type": "Namespace", "link": "Onspli/Eladmin/Modules.html", "name": "Onspli\\Eladmin\\Modules", "doc": "Namespace Onspli\\Eladmin\\Modules"},{"type": "Namespace", "link": "Onspli/Eladmin/Modules/Crud.html", "name": "Onspli\\Eladmin\\Modules\\Crud", "doc": "Namespace Onspli\\Eladmin\\Modules\\Crud"},{"type": "Namespace", "link": "Onspli/Eladmin/Modules/Crud/Chainset.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "doc": "Namespace Onspli\\Eladmin\\Modules\\Crud\\Chainset"},{"type": "Namespace", "link": "Onspli/Eladmin/Modules/Eloquent.html", "name": "Onspli\\Eladmin\\Modules\\Eloquent", "doc": "Namespace Onspli\\Eladmin\\Modules\\Eloquent"},
            {"type": "Interface", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/IAuth.html", "name": "Onspli\\Eladmin\\IAuth", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_loginFields", "name": "Onspli\\Eladmin\\IAuth::loginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_unauthorized", "name": "Onspli\\Eladmin\\IAuth::unauthorized", "doc": "&quot;This method is called when user is not autorized and loginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_login", "name": "Onspli\\Eladmin\\IAuth::login", "doc": "&quot;Eladmin calls this method during authentication.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_accountFields", "name": "Onspli\\Eladmin\\IAuth::accountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_accountUpdate", "name": "Onspli\\Eladmin\\IAuth::accountUpdate", "doc": "&quot;Eladmin calls this method during profile update.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_logout", "name": "Onspli\\Eladmin\\IAuth::logout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_authorize", "name": "Onspli\\Eladmin\\IAuth::authorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_userName", "name": "Onspli\\Eladmin\\IAuth::userName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
            
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Auth", "fromLink": "Onspli/Eladmin/Auth.html", "link": "Onspli/Eladmin/Auth/Password.html", "name": "Onspli\\Eladmin\\Auth\\Password", "doc": "&quot;Simple username\/password authorization.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method___construct", "name": "Onspli\\Eladmin\\Auth\\Password::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_loginFields", "name": "Onspli\\Eladmin\\Auth\\Password::loginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_unauthorized", "name": "Onspli\\Eladmin\\Auth\\Password::unauthorized", "doc": "&quot;This method is called when user is not autorized and loginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_login", "name": "Onspli\\Eladmin\\Auth\\Password::login", "doc": "&quot;Eladmin calls this method during authentication.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_logout", "name": "Onspli\\Eladmin\\Auth\\Password::logout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_authorize", "name": "Onspli\\Eladmin\\Auth\\Password::authorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_userName", "name": "Onspli\\Eladmin\\Auth\\Password::userName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_accountFields", "name": "Onspli\\Eladmin\\Auth\\Password::accountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Auth\\Password", "fromLink": "Onspli/Eladmin/Auth/Password.html", "link": "Onspli/Eladmin/Auth/Password.html#method_accountUpdate", "name": "Onspli\\Eladmin\\Auth\\Password::accountUpdate", "doc": "&quot;Eladmin calls this method during profile update.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html", "name": "Onspli\\Eladmin\\Chainset\\Chainset", "doc": "&quot;Chainset object is funny method to configure things.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method___construct", "name": "Onspli\\Eladmin\\Chainset\\Chainset::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method___isset", "name": "Onspli\\Eladmin\\Chainset\\Chainset::__isset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_cutChild", "name": "Onspli\\Eladmin\\Chainset\\Chainset::cutChild", "doc": "&quot;Remove child from linked list.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method___unset", "name": "Onspli\\Eladmin\\Chainset\\Chainset::__unset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method___get", "name": "Onspli\\Eladmin\\Chainset\\Chainset::__get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_setFirst", "name": "Onspli\\Eladmin\\Chainset\\Chainset::setFirst", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_getFirst", "name": "Onspli\\Eladmin\\Chainset\\Chainset::getFirst", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_setLast", "name": "Onspli\\Eladmin\\Chainset\\Chainset::setLast", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_getLast", "name": "Onspli\\Eladmin\\Chainset\\Chainset::getLast", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_current", "name": "Onspli\\Eladmin\\Chainset\\Chainset::current", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_key", "name": "Onspli\\Eladmin\\Chainset\\Chainset::key", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_next", "name": "Onspli\\Eladmin\\Chainset\\Chainset::next", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_rewind", "name": "Onspli\\Eladmin\\Chainset\\Chainset::rewind", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Chainset", "fromLink": "Onspli/Eladmin/Chainset/Chainset.html", "link": "Onspli/Eladmin/Chainset/Chainset.html#method_valid", "name": "Onspli\\Eladmin\\Chainset\\Chainset::valid", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Chainset", "fromLink": "Onspli/Eladmin/Chainset.html", "link": "Onspli/Eladmin/Chainset/Child.html", "name": "Onspli\\Eladmin\\Chainset\\Child", "doc": "&quot;Chainset object is funny method to configure things.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method___call", "name": "Onspli\\Eladmin\\Chainset\\Child::__call", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__setKey", "name": "Onspli\\Eladmin\\Chainset\\Child::_setKey", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__getKey", "name": "Onspli\\Eladmin\\Chainset\\Child::_getKey", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__setNext", "name": "Onspli\\Eladmin\\Chainset\\Child::_setNext", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__getNext", "name": "Onspli\\Eladmin\\Chainset\\Child::_getNext", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__setPrev", "name": "Onspli\\Eladmin\\Chainset\\Child::_setPrev", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__getPrev", "name": "Onspli\\Eladmin\\Chainset\\Child::_getPrev", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__setParent", "name": "Onspli\\Eladmin\\Chainset\\Child::_setParent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method__getParent", "name": "Onspli\\Eladmin\\Chainset\\Child::_getParent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method_before", "name": "Onspli\\Eladmin\\Chainset\\Child::before", "doc": "&quot;Place child just before $target.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Chainset\\Child", "fromLink": "Onspli/Eladmin/Chainset/Child.html", "link": "Onspli/Eladmin/Chainset/Child.html#method_after", "name": "Onspli\\Eladmin\\Chainset\\Child::after", "doc": "&quot;Place child just after $target.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/Core.html", "name": "Onspli\\Eladmin\\Core", "doc": "&quot;Eladmin core class.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method___construct", "name": "Onspli\\Eladmin\\Core::__construct", "doc": "&quot;Each module has to be initialized with eladmin instance and its own elakey.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_errorHandler", "name": "Onspli\\Eladmin\\Core::errorHandler", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_run", "name": "Onspli\\Eladmin\\Core::run", "doc": "&quot;Run Eladmin. It&#039;s just a wrapper of method runNoCatch catching exceptions.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_runNoCatch", "name": "Onspli\\Eladmin\\Core::runNoCatch", "doc": "&quot;Run Eladmin. The main function which processes the requests.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_title", "name": "Onspli\\Eladmin\\Core::title", "doc": "&quot;Return administration title to show it in templates.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_blade", "name": "Onspli\\Eladmin\\Core::blade", "doc": "&quot;Return Blade instance&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_version", "name": "Onspli\\Eladmin\\Core::version", "doc": "&quot;Get eladmin version.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_iauth", "name": "Onspli\\Eladmin\\Core::iauth", "doc": "&quot;Return authorization instance.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_actionkey", "name": "Onspli\\Eladmin\\Core::actionkey", "doc": "&quot;Return requested action key, null if no action requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_modulekey", "name": "Onspli\\Eladmin\\Core::modulekey", "doc": "&quot;Return requested module key, null if no module requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_CSRFToken", "name": "Onspli\\Eladmin\\Core::CSRFToken", "doc": "&quot;Generate CSRF token&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_assetpath", "name": "Onspli\\Eladmin\\Core::assetpath", "doc": "&quot;Return requested asset path, null if no asset requested&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_renderAsset", "name": "Onspli\\Eladmin\\Core::renderAsset", "doc": "&quot;Determinate asset content-type and render it.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_module", "name": "Onspli\\Eladmin\\Core::module", "doc": "&quot;Return module instance or null if not authorized. Default $key = modulekey()&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_modules", "name": "Onspli\\Eladmin\\Core::modules", "doc": "&quot;Return instances of all authorized modules.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_firstAuthorizedModuleKey", "name": "Onspli\\Eladmin\\Core::firstAuthorizedModuleKey", "doc": "&quot;return first authorized module key&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_views", "name": "Onspli\\Eladmin\\Core::views", "doc": "&quot;Extends array of directories of views and assets.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_isAjaxRequest", "name": "Onspli\\Eladmin\\Core::isAjaxRequest", "doc": "&quot;Check if eladmin was run with ajax request.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_redirect", "name": "Onspli\\Eladmin\\Core::redirect", "doc": "&quot;Redirect (or exit if ajax request). Default url = home&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_CSRFAuth", "name": "Onspli\\Eladmin\\Core::CSRFAuth", "doc": "&quot;Check if CSRF token is valid&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_username", "name": "Onspli\\Eladmin\\Core::username", "doc": "&quot;Returns username to show it in templates. Returns null if authorization is off.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_accountFields", "name": "Onspli\\Eladmin\\Core::accountFields", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_actionAccountUpdate", "name": "Onspli\\Eladmin\\Core::actionAccountUpdate", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_actionAccountForm", "name": "Onspli\\Eladmin\\Core::actionAccountForm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_log", "name": "Onspli\\Eladmin\\Core::log", "doc": "&quot;monolog Logger&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initLocalization", "name": "Onspli\\Eladmin\\Core::initLocalization", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initSessions", "name": "Onspli\\Eladmin\\Core::initSessions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initCache", "name": "Onspli\\Eladmin\\Core::initCache", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initAuthorization", "name": "Onspli\\Eladmin\\Core::initAuthorization", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initAllModules", "name": "Onspli\\Eladmin\\Core::initAllModules", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Core", "fromLink": "Onspli/Eladmin/Core.html", "link": "Onspli/Eladmin/Core.html#method_initMonolog", "name": "Onspli\\Eladmin\\Core::initMonolog", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/BadRequestException.html", "name": "Onspli\\Eladmin\\Exception\\BadRequestException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\BadRequestException", "fromLink": "Onspli/Eladmin/Exception/BadRequestException.html", "link": "Onspli/Eladmin/Exception/BadRequestException.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\BadRequestException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/Exception.html", "name": "Onspli\\Eladmin\\Exception\\Exception", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\Exception", "fromLink": "Onspli/Eladmin/Exception/Exception.html", "link": "Onspli/Eladmin/Exception/Exception.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\Exception::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Exception", "fromLink": "Onspli/Eladmin/Exception.html", "link": "Onspli/Eladmin/Exception/UnauthorizedException.html", "name": "Onspli\\Eladmin\\Exception\\UnauthorizedException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Exception\\UnauthorizedException", "fromLink": "Onspli/Eladmin/Exception/UnauthorizedException.html", "link": "Onspli/Eladmin/Exception/UnauthorizedException.html#method___construct", "name": "Onspli\\Eladmin\\Exception\\UnauthorizedException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/IAuth.html", "name": "Onspli\\Eladmin\\IAuth", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_loginFields", "name": "Onspli\\Eladmin\\IAuth::loginFields", "doc": "&quot;Return an array of login fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_unauthorized", "name": "Onspli\\Eladmin\\IAuth::unauthorized", "doc": "&quot;This method is called when user is not autorized and loginFileds returns null.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_login", "name": "Onspli\\Eladmin\\IAuth::login", "doc": "&quot;Eladmin calls this method during authentication.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_accountFields", "name": "Onspli\\Eladmin\\IAuth::accountFields", "doc": "&quot;Return an array of profile fields in the form of field_name=&gt;[label=&gt;input label, type=&gt;input_type]\nRetrurn null if Eladmin edit profile dialog should be disabled.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_accountUpdate", "name": "Onspli\\Eladmin\\IAuth::accountUpdate", "doc": "&quot;Eladmin calls this method during profile update.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_logout", "name": "Onspli\\Eladmin\\IAuth::logout", "doc": "&quot;Logout.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_authorize", "name": "Onspli\\Eladmin\\IAuth::authorize", "doc": "&quot;Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\IAuth", "fromLink": "Onspli/Eladmin/IAuth.html", "link": "Onspli/Eladmin/IAuth.html#method_userName", "name": "Onspli\\Eladmin\\IAuth::userName", "doc": "&quot;Get user&#039;s name to show it in admin.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin", "fromLink": "Onspli/Eladmin.html", "link": "Onspli/Eladmin/Module.html", "name": "Onspli\\Eladmin\\Module", "doc": "&quot;Generic Eladmin module.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method___construct", "name": "Onspli\\Eladmin\\Module::__construct", "doc": "&quot;Each module has to be initialized with eladmin instance and its own elakey.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_core", "name": "Onspli\\Eladmin\\Module::core", "doc": "&quot;Return core instance&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_elakey", "name": "Onspli\\Eladmin\\Module::elakey", "doc": "&quot;Each module has its elakey - index in modules array - used to address requests.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_auth", "name": "Onspli\\Eladmin\\Module::auth", "doc": "&quot;Check if user is authorized to do action, or athorized to access module at all.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_title", "name": "Onspli\\Eladmin\\Module::title", "doc": "&quot;Get name of the module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_icon", "name": "Onspli\\Eladmin\\Module::icon", "doc": "&quot;Get icon of the module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_requestUrl", "name": "Onspli\\Eladmin\\Module::requestUrl", "doc": "&quot;Return url for this module.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_assetUrl", "name": "Onspli\\Eladmin\\Module::assetUrl", "doc": "&quot;Create asset url, file path relative to \/assets directory. Default $version = time()&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_prepare", "name": "Onspli\\Eladmin\\Module::prepare", "doc": "&quot;Runs before any action is executed.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_roles", "name": "Onspli\\Eladmin\\Module::roles", "doc": "&quot;Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_setRoles", "name": "Onspli\\Eladmin\\Module::setRoles", "doc": "&quot;Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_views", "name": "Onspli\\Eladmin\\Module::views", "doc": "&quot;Extends array of directories of views and assets.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_blade", "name": "Onspli\\Eladmin\\Module::blade", "doc": "&quot;Return Blade instance&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_render", "name": "Onspli\\Eladmin\\Module::render", "doc": "&quot;Return rendered view.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_renderAsset", "name": "Onspli\\Eladmin\\Module::renderAsset", "doc": "&quot;Determinate asset content-type and render it.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_actions", "name": "Onspli\\Eladmin\\Module::actions", "doc": "&quot;Return array of all defined actions.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_hasAction", "name": "Onspli\\Eladmin\\Module::hasAction", "doc": "&quot;Check if actions is defined.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_isAction", "name": "Onspli\\Eladmin\\Module::isAction", "doc": "&quot;Check if actions is executed.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_parseAction", "name": "Onspli\\Eladmin\\Module::parseAction", "doc": "&quot;We want action keys to be case insensitive. This converts action to lowercase.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_renderText", "name": "Onspli\\Eladmin\\Module::renderText", "doc": "&quot;Convinient method for plain text output. Sets HTTP header text\/plain and echo $str.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_renderHtml", "name": "Onspli\\Eladmin\\Module::renderHtml", "doc": "&quot;Convinient method for html output. Sets HTTP header text\/html and echo $str.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Module", "fromLink": "Onspli/Eladmin/Module.html", "link": "Onspli/Eladmin/Module.html#method_renderJson", "name": "Onspli\\Eladmin\\Module::renderJson", "doc": "&quot;Convinient method for json output. Sets HTTP header application\/json and echo serialized $json.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_getName", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::getName", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_getAction", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::getAction", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_hidden", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::hidden", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_confirm", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::confirm", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_done", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::done", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_bulk", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::bulk", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_nonbulk", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::nonbulk", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_form", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::form", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_nonform", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::nonform", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_nonlistable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::nonlistable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_listable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::listable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_noneditable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::noneditable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_editable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::editable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_danger", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::danger", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_primary", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::primary", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_secondary", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::secondary", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_success", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::success", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Action.html#method_warning", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Action::warning", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html#method___isset", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions::__isset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html#method___unset", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions::__unset", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Actions.html#method___get", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Actions::__get", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_getName", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::getName", "doc": "&quot;Get internal name of the column.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_getValue", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::getValue", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_evalProperty", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::evalProperty", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_raw", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::raw", "doc": "&quot;Output raw value (i.e. HTML)&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_escaped", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::escaped", "doc": "&quot;Output escaped value.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_nonlistable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::nonlistable", "doc": "&quot;Do not show the column in the table.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_listable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::listable", "doc": "&quot;Show the column in the table.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_nonsearchable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::nonsearchable", "doc": "&quot;Do not use the column for searching.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_searchable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::searchable", "doc": "&quot;Use the column for searching.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_nonsortable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::nonsortable", "doc": "&quot;Do not sort by the column.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_sortable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::sortable", "doc": "&quot;Use the column for sorting.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_noneditable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::noneditable", "doc": "&quot;Hide the column in the edit form.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_editable", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::editable", "doc": "&quot;Show the column in the edit form.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_disabled", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::disabled", "doc": "&quot;Disable editing column&#039;s value.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_enabled", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::enabled", "doc": "&quot;Enable editing column&#039;s value.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_limit", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::limit", "doc": "&quot;Max length of value to be shown in the table.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_input", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::input", "doc": "&quot;Set the type of input.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_textarea", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::textarea", "doc": "&quot;Set the type of input to textarea.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_select", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::select", "doc": "&quot;Set the type of input to select.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_hidden", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::hidden", "doc": "&quot;Shortcut for nonlistable &amp;amp;&amp;amp; noneditable &amp;amp;&amp;amp; disabled&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_belongsTo", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::belongsTo", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_format", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::format", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_get", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_set", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::set", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_datetime", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::datetime", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Column.html#method_validate", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Column::validate", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Columns.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Columns", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Columns", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Columns.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Columns.html#method_getConfig", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Columns::getConfig", "doc": "&quot;generate array of actions for one column&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Filter.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Filter", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Filter", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset/Filter.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Filter.html#method_select", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Filter::select", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Chainset", "fromLink": "Onspli/Eladmin/Modules/Crud/Chainset.html", "link": "Onspli/Eladmin/Modules/Crud/Chainset/Filters.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Chainset\\Filters", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "doc": "&quot;Generic CRUD module.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_implementsSoftDeletes", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::implementsSoftDeletes", "doc": "&quot;IMPLEMENT. Does CRUD use soft deletes?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_implementsSearch", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::implementsSearch", "doc": "&quot;IMPLEMENT. Does CRUD support searching?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_implementsPaging", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::implementsPaging", "doc": "&quot;IMPLEMENT. Does CRUD support paging?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_implementsSorting", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::implementsSorting", "doc": "&quot;IMPLEMENT. Does CRUD support sorting?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_implementsFilters", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::implementsFilters", "doc": "&quot;IMPLEMENT. Does CRUD support filtering?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_primary", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::primary", "doc": "&quot;IMPLEMENT. Name of primary key column. Default is &#039;id&#039;.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_create", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::create", "doc": "&quot;IMPLEMENT. Create item.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_update", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::update", "doc": "&quot;IMPLEMENT. Update item.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_get", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::get", "doc": "&quot;IMPLEMENT. Read one row, or get default one ($id = null)\nReturns row as an associative array [&#039;columnName&#039; =&gt; &#039;value&#039;]&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_delete", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::delete", "doc": "&quot;IMPLEMENT. Hard delete row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_softDelete", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::softDelete", "doc": "&quot;IMPLEMENT. Soft delete row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_restore", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::restore", "doc": "&quot;IMPLEMENT. Restore soft deleted row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_read", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::read", "doc": "&quot;IMPLEMENT. Fetch an array of rows.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_crudColumns", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::crudColumns", "doc": "&quot;IMPLEMENT. Default columns chainset. Override to configure columns.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_crudActions", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::crudActions", "doc": "&quot;Default actions chainset. Override to configure actions.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_crudFilters", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::crudFilters", "doc": "&quot;Default filters chainset. Override to configure filters.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_getCrudColumns", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::getCrudColumns", "doc": "&quot;Get columns chainset.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_getCrudActions", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::getCrudActions", "doc": "&quot;Get actions chainset.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_getCrudFilters", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::getCrudFilters", "doc": "&quot;Get filters chainset.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_views", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::views", "doc": "&quot;Extends array of directories of views and assets.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_id", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::id", "doc": "&quot;Return ID of the row which should be affected by the action.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_rowValuesArray", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::rowValuesArray", "doc": "&quot;generate array of values for one row&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_rowActionsArray", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::rowActionsArray", "doc": "&quot;generate array of actions for one item&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_validateAndModify", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::validateAndModify", "doc": "&quot;Validate and modify values before saving.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_prepare", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::prepare", "doc": "&quot;Runs before any action is executed.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionCreateForm", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionCreateForm", "doc": "&quot;ACTION. Show form - create entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionUpdateForm", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionUpdateForm", "doc": "&quot;ACTION. Show form - edit entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionRead", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionRead", "doc": "&quot;ACTION. List database entries.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionUpdate", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionUpdate", "doc": "&quot;ACTION. Edit database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionCreate", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionCreate", "doc": "&quot;ACTION. Create database entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionDelete", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionDelete", "doc": "&quot;ACTION. Hard delete.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionSoftDelete", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionSoftDelete", "doc": "&quot;ACTION. Soft delete.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Crud\\Crud", "fromLink": "Onspli/Eladmin/Modules/Crud/Crud.html", "link": "Onspli/Eladmin/Modules/Crud/Crud.html#method_actionRestore", "name": "Onspli\\Eladmin\\Modules\\Crud\\Crud::actionRestore", "doc": "&quot;ACTION. Restore.&quot;"},
            
            {"type": "Class", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent", "fromLink": "Onspli/Eladmin/Modules/Eloquent.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "doc": "&quot;Crud module for Eloquent model.&quot;"},
                                                        {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_implementsSoftDeletes", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::implementsSoftDeletes", "doc": "&quot;IMPLEMENT. Does CRUD use soft deletes?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_implementsSorting", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::implementsSorting", "doc": "&quot;IMPLEMENT. Does CRUD support sorting?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_implementsPaging", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::implementsPaging", "doc": "&quot;IMPLEMENT. Does CRUD support paging?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_implementsSearch", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::implementsSearch", "doc": "&quot;IMPLEMENT. Does CRUD support searching?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_implementsFilters", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::implementsFilters", "doc": "&quot;IMPLEMENT. Does CRUD support filtering?&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_model", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::model", "doc": "&quot;Return model instance for action.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_primary", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::primary", "doc": "&quot;Primary column name.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_updateOrCreate", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::updateOrCreate", "doc": "&quot;Update or create entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_prepare", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::prepare", "doc": "&quot;Prepare action. Initialise model() with the requested db entry.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_create", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::create", "doc": "&quot;IMPLEMENT. Create item.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_update", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::update", "doc": "&quot;IMPLEMENT. Update item.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_get", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::get", "doc": "&quot;IMPLEMENT. Read one row, or get default one ($id = null)\nReturns row as an associative array [&#039;columnName&#039; =&gt; &#039;value&#039;]&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_delete", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::delete", "doc": "&quot;IMPLEMENT. Hard delete row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_read", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::read", "doc": "&quot;IMPLEMENT. Fetch an array of rows.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_softDelete", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::softDelete", "doc": "&quot;IMPLEMENT. Soft delete row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_restore", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::restore", "doc": "&quot;IMPLEMENT. Restore soft deleted row.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_tableExists", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::tableExists", "doc": "&quot;Check if table for the model exists in the database;&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_tableColumns", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::tableColumns", "doc": "&quot;Get an array of table columns.&quot;"},
                    {"type": "Method", "fromName": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud", "fromLink": "Onspli/Eladmin/Modules/Eloquent/Crud.html", "link": "Onspli/Eladmin/Modules/Eloquent/Crud.html#method_crudColumns", "name": "Onspli\\Eladmin\\Modules\\Eloquent\\Crud::crudColumns", "doc": "&quot;Default columns setting.&quot;"},
            
            
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


