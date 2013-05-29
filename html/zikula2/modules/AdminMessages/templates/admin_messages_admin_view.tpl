{*  $Id: admin_messages_admin_view.htm 27048 2009-10-21 14:55:13Z drak $  *}
{gt text="Messages list" assign=templatetitle}
{include file="admin_messages_admin_menu.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=windowlist.png set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <table class="z-admintable">
        <thead>
            <tr>
                <th>{gt text="Internal ID"}</th>
                <th>{gt text="Title"}</th>
                <th>{gt text="Language"}</th>
                <th>{gt text="Visibility"}</th>
                <th>{gt text="Active"}</th>
                <th>{gt text="Expiration"}</th>
                <th>{gt text="Expiration date"}</th>
                <th>{gt text="Actions"}</th>
            </tr>
        </thead>
        <tbody>
            {section name=items loop=$items}
            <tr class="{cycle values="z-odd,z-even"}">
                <td>{$items[items].mid|safetext}</td>
                 <td>{$items[items].title|safetext}</td>
                 <td>{$items[items].language|safetext}</td>
                 <td>{$items[items].view|safetext}</td>
                 <td>{$items[items].active|safetext}</td>
                 <td>{$items[items].expire|safetext}</td>
                 <td>{$items[items].expiredate|safetext}</td>
                 <td>
                     {assign var="options" value=$items[items].options}
                     {section name=options loop=$options}
                     <a href="{$options[options].url|safetext}">
                         {img modname=core set=icons/extrasmall src=$options[options].image title=$options[options].title alt=$options[options].title}
                     </a>
                     {/section}
                 </td>
             </tr>
             {sectionelse}
             <tr class="z-admintableempty">
                 <td colspan="8">
                     {gt text="No items found."}
                 </td>
             </tr>
             {/section}
            </tbody>
        </table>
        {pager rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum shift=1 img_prev=images/icons/extrasmall/previous.png img_next=images/icons/extrasmall/next.png}
    </div>