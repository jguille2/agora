{gt text="admin message" assign=itemname}
{gt text="Edit %s" tag1=$itemname assign=templatetitle}
{include file="admin_messages_admin_menu.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=edit.png set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <form id="adminmsgs_admin_modifyform" class="z-form z-linear" action="{modurl modname='AdminMessages' type='admin' func='update'}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <input type="hidden" name="message[mid]" value="{$item.mid|safetext}" />
            <input type="hidden" name="message[oldtime]" value="{$item.date|safetext}" />
            <fieldset>
                <legend>{gt text="Message"}</legend>
                <div class="z-formrow">
                    <label for="admin_messages_title">{gt text="Title"}</label>
                    <input id="admin_messages_title" class="z-form-text" name="message[title]" type="text" size="50" maxlength="100" value="{$item.title|safetext}" />
                </div>
                {if $multilingual}
                <div class="z-formrow">
                    <label for="admin_messages_language">{gt text="Language"}</label>
                    {html_select_languages id=admin_messages_language name=message[language] all=true installed=true selected=$item.language}
                </div>
                {/if}
                <div class="z-formrow">
                    <label for="admin_messages_content">{gt text="Content"}</label>
                    <textarea id="admin_messages_content" class="z-form-text" name="message[content]" cols="50" rows="10">{$item.content|safetext}</textarea>
                </div>
                <div class="z-formrow">
                    <label for="admin_messages_active">{gt text="Active"}</label>
                    <div id="admin_messages_active">
                        <input id="admin_messages_active_yes" name="message[active]" type="radio" value="1" {if $item.active eq 1} checked="checked"{/if} />
                               <label for="admin_messages_active_yes">{gt text="Yes"}</label>
                        <input id="admin_messages_active_no" name="message[active]" type="radio" value="0" {if $item.active eq 0} checked="checked"{/if} />
                               <label for="admin_messages_active_no">{gt text="No"}</label>
                    </div>
                </div>
                <div class="z-formrow">
                    <label for="admin_messages_changestartday">{gt text="Reset publication date"}</label>
                    <div id="admin_messages_changestartday">
                        <input id="admin_messages_changestartday_yes" name="message[changestartday]" type="radio" value="1" checked="checked" />
                        <label for="admin_messages_changestartday_yes">{gt text="Yes"}</label>
                        <input id="admin_messages_changestartday_no" name="message[changestartday]" type="radio" value="0" />
                        <label for="admin_messages_changestartday_no">{gt text="No"}</label>
                    </div>
                </div>
                <div class="z-formrow">
                    <label for="admin_messages_expire">{gt text="Expiration"}</label>
                    <div>
                        <input id="admin_messages_expire" name="message[expire]" type="text" size="5" maxlength="5" value="{$item.expire/86400}" />
                        <span class="z-sub">{gt text="days (0 = never)"}</span>
                    </div>
                </div>
                <div class="z-formrow">
                    <label for="admin_messages_view">{gt text="Visibility"}</label>
                    <div>
                        <select id="admin_messages_view" name="message[view]">
                            {if $item.view eq 1}
                            <option value="1" selected="selected">{gt text="All visitors"}</option>
                            {else}
                            <option value="1">{gt text="All visitors"}</option>
                            {/if}
                            {if $item.view eq 2}
                            <option value="2" selected="selected">{gt text="Registered users only"}</option>
                            {else}
                            <option value="2">{gt text="Registered users only"}</option>
                            {/if}
                            {if $item.view eq 3}
                            <option value="3" selected="selected">{gt text="Anonymous guests only"}</option>
                            {else}
                            <option value="3">{gt text="Anonymous guests only"}</option>
                            {/if}
                            {if $item.view eq 4}
                            <option value="4" selected="selected">{gt text="Administrators only"}</option>
                            {else}
                            <option value="4">{gt text="Administrators only"}</option>
                            {/if}
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="z-formbuttons">
                {button src=button_ok.png set=icons/small __alt="Save" __title="Save"}
                <a href="{modurl modname='AdminMessages' type='admin' func='view'}">
                    {img modname=core src=button_cancel.png set=icons/small __alt="Cancel" __title="Cancel"}
                </a>
            </div>
        </div>
    </form>
</div>
