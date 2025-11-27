<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines https://www.simplemachines.org
 * @copyright 2021 Simple Machines and individual contributors
 * @license https://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.1 RC4
 */

/**
 * The top part of the outer layer of the boardindex
 */
function template_boardindex_outer_above()
{
	template_newsfader();
}

/**
 * This shows the newsfader
 */
function template_newsfader()
{
	global $context, $settings, $txt;

	// Show the news fader?  (assuming there are things to show...)
	if (empty($settings['show_newsfader']) || empty($context['news_lines']))
		return;

	echo '
	<div class="databox databox--neutral news">
		<div class="databox-icon">', icon('fas fa-newspaper'), '</div>
		<div class="databox-content">
			<div class="databox-text">
				<ul id="smf_slider" class="news-fader-items">';

	foreach ($context['news_lines'] as $news)
		echo '
					<li>', $news, '</li>';

	echo '
				</ul>
			</div>
		</div>
	</div>';

	echo '
	<script>
		jQuery("#smf_slider").slippry({
			pause: ', $settings['newsfader_time'], ',
			adaptiveHeight: false,
			captions: 0,
			controls: 0,
			auto: getComputedStyle(document.body).getPropertyValue("--screen") === "none",
		});
	</script>';
}

/**
 * This actually displays the board index
 */
function template_main()
{
	global $context, $txt, $scripturl;
	vision_divbox();
	echo '
	<div id="nodeList" class="boardindex_table boardindextable nodeList hoverNodes nodeSeparateTitleDesc gridNodes gridNodes-3 separateNodes imgNodes nodeImgAbove nodeImgBg">';

	/* Each category in categories is made up of:
	id, href, link, name, is_collapsed (is it collapsed?), can_collapse (is it okay if it is?),
	new (is it new?), collapse_href (href to collapse/expand), collapse_image (up/down image),
	and boards. (see below.) */
	foreach ($context['categories'] as $category)
	{
		// If theres no parent boards we can see, avoid showing an empty category (unless its collapsed)
		if (empty($category['boards']) && !$category['is_collapsed'])
			continue;

		echo '
		<div class="main_container">
			<div class="cat_bar ', $category['is_collapsed'] ? 'collapsed' : '', '" id="category_', $category['id'], '">
				<h3 class="catbg">';

		// If this category even can collapse, show a link to collapse it.
		if ($category['can_collapse'])
			echo '
			<i id="category_', $category['id'], '_upshrink" class="fa ', $category['is_collapsed'] ? 'toggle_down' : 'toggle_up', ' floatright fa-lg" data-collapsed="', (int) $category['is_collapsed'], '" title="', !$category['is_collapsed'] ? $txt['hide_category'] : $txt['show_category'] ,'" style="display: none;"></i>';

		echo '
					', $category['link'], '
				</h3>', !empty($category['description']) ? '
				<div class="desc">' . $category['description'] . '</div>' : '', '
			</div>
			<div id="category_', $category['id'], '_boards" ', (!empty($category['css_class']) ? ('class="' . $category['css_class'] . '"') : ''), '>
			<div class="block-body">';

		/* Each board in each category's boards has:
		new (is it new?), id, name, description, moderators (see below), link_moderators (just a list.),
		children (see below.), link_children (easier to use.), children_new (are they new?),
		topics (# of), posts (# of), link, href, and last_post. (see below.) */
		foreach ($category['boards'] as $board)
		{
			echo '
				<div id="board_', $board['id'], '" class="up_contain node node--id2 node--depth2 node--forum node--read th_nodes_right ', (!empty($board['css_class']) ? $board['css_class'] : ''), '">
				<div class="node-body">
					<div class="board_icon">
						', function_exists('template_bi_' . $board['type'] . '_icon') ? call_user_func('template_bi_' . $board['type'] . '_icon', $board) : template_bi_board_icon($board), '
					</div>
					<div class="info">
						', function_exists('template_bi_' . $board['type'] . '_info') ? call_user_func('template_bi_' . $board['type'] . '_info', $board) : template_bi_board_info($board), '';
	// Won't somebody think of the children!
			if (function_exists('template_bi_' . $board['type'] . '_children'))
				call_user_func('template_bi_' . $board['type'] . '_children', $board);
			else
				template_bi_board_children($board);

			echo '
					</div><!-- .info -->';

			// Show the last post if there is one.
			echo'
			<div class="block-footer has-flexbox">
					<div class="lastpost lpr_border">
						', function_exists('template_bi_' . $board['type'] . '_lastpost') ? call_user_func('template_bi_' . $board['type'] . '_lastpost', $board) : template_bi_board_lastpost($board), '
					</div>';
			// Show some basic information about the number of posts, etc.
			echo '
					<div class="board_stats">
						', function_exists('template_bi_' . $board['type'] . '_stats') ? call_user_func('template_bi_' . $board['type'] . '_stats', $board) : template_bi_board_stats($board), '
					</div>';
				echo '
				</div>';

			echo '
			</div>
				</div><!-- #board_[id] -->';
		}

		echo '
		     </div>
			</div><!-- #category_[id]_boards -->
		</div><!-- .main_container -->';
	}

	echo '
	</div><!-- #boardindex_table -->';

	// Show the mark all as read button?
	if ($context['user']['is_logged'] && !empty($context['categories']))
		echo '
	<div class="mark_read">
		', template_button_strip($context['mark_read_button'], 'right'), '
	</div>';
}

/**
 * Outputs the board icon for a standard board.
 *
 * @param array $board Current board information.
 */
function template_bi_board_icon($board)
{
	global $context, $scripturl;

	$icon_type = $board['new'] ? 'fas' : 'far';

	echo '
		<a href="', ($context['user']['is_guest'] ? $board['href'] : $scripturl . '?action=unread;board=' . $board['id'] . '.0;children'), '" class="board_', $board['board_class'], '"', !empty($board['board_tooltip']) ? ' title="' . $board['board_tooltip'] . '"' : '', '>
			', icon("$icon_type fa-comments"), '
		</a>';
}

/**
 * Outputs the board icon for a redirect.
 *
 * @param array $board Current board information.
 */
function template_bi_redirect_icon($board)
{
	global $context, $scripturl;

	echo '
		<a href="', $board['href'], '" class="board_', $board['board_class'], '"', !empty($board['board_tooltip']) ? ' title="' . $board['board_tooltip'] . '"' : '', '>
			', icon('fas fa-external-link-alt'), '
		</a>';
}

/**
 * Outputs the board info for a standard board or redirect.
 *
 * @param array $board Current board information.
 */
function template_bi_board_info($board)
{
	global $context, $scripturl, $txt;

	echo '
		<a class="subject mobile_subject" href="', $board['href'], '" id="b', $board['id'], '">
			', $board['name'], '
		</a>';

	// Has it outstanding posts for approval?
	if ($board['can_approve_posts'] && ($board['unapproved_posts'] || $board['unapproved_topics']))
		echo '
		<a href="', $scripturl, '?action=moderate;area=postmod;sa=', ($board['unapproved_topics'] > 0 ? 'topics' : 'posts'), ';brd=', $board['id'], ';', $context['session_var'], '=', $context['session_id'], '" title="', sprintf($txt['unapproved_posts'], $board['unapproved_topics'], $board['unapproved_posts']), '" class="moderation_link amt">!</a>';

	echo '
		<div class="board_description">', $board['description'], '</div>';

	// Show the "Moderators: ". Each has name, href, link, and id. (but we're gonna use link_moderators.)
	if (!empty($board['link_moderators']))
		echo '
		<p class="moderators">', count($board['link_moderators']) == 1 ? icon('fas fa-user').' '.$txt['moderator'] : icon('fas fa-user-friends').' '.$txt['moderators'], ': ', implode(', ', $board['link_moderators']), '</p>';
}

/**
 * Outputs the board stats for a standard board.
 *
 * @param array $board Current board information.
 */
function template_bi_board_stats($board)
{
	echo '
		<div>', icon('far fa-copy'), ' ', comma_format($board['posts']), '</div>
		<div>', icon('fas fa-file-alt'), ' ', comma_format($board['topics']), '</div>';
}

/**
 * Outputs the board stats for a redirect.
 *
 * @param array $board Current board information.
 */
function template_bi_redirect_stats($board)
{
	global $txt;

	echo '
		<div>', icon('fas fa-external-link-alt'), ' ', comma_format($board['posts']), '</div>';
}

/**
 * Outputs the board lastposts for a standard board or a redirect.
 * When on a mobile device, this may be hidden if no last post exists.
 *
 * @param array $board Current board information.
 */
function template_bi_board_lastpost($board)
{
	if (empty($board['last_post']['id']))
		return;

	echo '
		<div class="topic-item">
			<div class="topic-item-poster-avatar">', $board['last_post']['member']['avatar']['image'], '</div>
			<div class="topic-item-content">
				<div class="topic-item-title">', $board['last_post']['link'], '</div>
				<div class="topic-item-details">
					<div class="topic-item-poster">', $board['last_post']['member']['link'], '</div>
					<div class="topic-item-time">', icon('far fa-clock'), ' ', timeformat($board['last_post']['timestamp']), '</div>
				</div>
			</div>
		</div>';
}

/**
 * Outputs the board children for a standard board.
 *
 * @param array $board Current board information.
 */
function template_bi_board_children($board)
{
	global $txt, $scripturl, $context;

	// Show the "Child Boards: ". (there's a link_children but we're going to bold the new ones...)
	if (!empty($board['children']))
	{
		// Sort the links into an array with new boards bold so it can be imploded.
		$children = array();
		/* Each child in each board's children has:
			id, name, description, new (is it new?), topics (#), posts (#), href, link, and last_post. */
		foreach ($board['children'] as $child)
		{
			if (!$child['is_redirect'])
				$child['link'] = '' . ($child['new'] ? '<a href="' . $scripturl . '?action=unread;board=' . $child['id'] . '" title="' . $txt['new_posts'] . ' (' . $txt['board_topics'] . ': ' . comma_format($child['topics']) . ', ' . $txt['posts'] . ': ' . comma_format($child['posts']) . ')" class="new_posts1"><i class="fas fa-bowling-ball" style="color:orange"></i></a>' : '') . '<a class="flex-1 text-sm truncate" href="' . $child['href'] . '" ' . ($child['new'] ? 'class="board_new_posts1" ' : '') . 'title="' . ($child['new'] ? $txt['new_posts'] : $txt['old_posts']) . ' (' . $txt['board_topics'] . ': ' . comma_format($child['topics']) . ', ' . $txt['posts'] . ': ' . comma_format($child['posts']) . ')">' . $child['name'] . '</a>';
			else
				$child['link'] = '<a href="' . $child['href'] . '" title="' . comma_format($child['posts']) . ' ' . $txt['redirects'] . ' - ' . $child['short_description'] . '">' . $child['name'] . '</a>';

			// Has it posts awaiting approval?
			if ($child['can_approve_posts'] && ($child['unapproved_posts'] || $child['unapproved_topics']))
				$child['link'] .= ' <a href="' . $scripturl . '?action=moderate;area=postmod;sa=' . ($child['unapproved_topics'] > 0 ? 'topics' : 'posts') . ';brd=' . $child['id'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . sprintf($txt['unapproved_posts'], $child['unapproved_topics'], $child['unapproved_posts']) . '" class="moderation_link amt">!</a>';

			$children[] = $child['new'] ? '<span class="strong items-center space-x-2"> ' . $child['link'] . '</span>' : '<span class="items-center space-x-2"><i class="fas fa-bowling-ball" style="color:#bcbdc3;"></i> ' . $child['link'] . '</span>'; 
		}

		echo '
			<div id="board_', $board['id'], '_children" class="children">
				<p><strong id="child_list_', $board['id'], '"></strong>', implode($children), '</p>
			</div>';
	}
}

/**
 * The lower part of the outer layer of the board index
 */
function template_boardindex_outer_below()
{
	template_info_center();
}

/**
 * Displays the info center
 */
function template_info_center()
{
	global $context, $options, $txt;

	if (empty($context['info_center']))
		return;

	// Here's where the "Info Center" starts...
	echo '
	<div class="roundframe" id="info_center">
		<div class="title_bar">
			<h3 class="titlebg">
				<i class="fa toggle_up fa-lg floatright" id="upshrink_ic" title="', $txt['hide_infocenter'], '" style="display: none;"></i>
				<a href="#" id="upshrink_link">', sprintf($txt['info_center_title'], $context['forum_name_html_safe']), '</a>
			</h3>
		</div>
		<div id="upshrink_stats"', empty($options['collapse_header_ic']) ? '' : ' style="display: none;"', '>
		<div class="grid grid-cols-1 gap-4 lg:grid-cols-4">';

	foreach ($context['info_center'] as $block)
	{
		$func = 'template_ic_block_' . $block['tpl'];
		$func();
	}

	echo '
		</div><!-- #upshrink_stats -->
	</div><!-- #info_center -->';

	// Info center collapse object.
	echo '
	<script>
		var oInfoCenterToggle = new smc_Toggle({
			bToggleEnabled: true,
			bCurrentlyCollapsed: ', empty($options['collapse_header_ic']) ? 'false' : 'true', ',
			aSwappableContainers: [
				\'upshrink_stats\'
			],
			aSwapImages: [
				{
					sId: \'upshrink_ic\',
					altExpanded: ', JavaScriptEscape($txt['hide_infocenter']), ',
					altCollapsed: ', JavaScriptEscape($txt['show_infocenter']), '
				}
			],
			aSwapLinks: [
				{
					sId: \'upshrink_link\',
					msgExpanded: ', JavaScriptEscape(sprintf($txt['info_center_title'], $context['forum_name_html_safe'])), ',
					msgCollapsed: ', JavaScriptEscape(sprintf($txt['info_center_title'], $context['forum_name_html_safe'])), '
				}
			],
			oThemeOptions: {
				bUseThemeSettings: ', $context['user']['is_guest'] ? 'false' : 'true', ',
				sOptionName: \'collapse_header_ic\',
				sSessionId: smf_session_id,
				sSessionVar: smf_session_var,
			},
			oCookieOptions: {
				bUseCookie: ', $context['user']['is_guest'] ? 'true' : 'false', ',
				sCookieName: \'upshrinkIC\'
			}
		});
	</script>';
}

/**
 * The recent posts section of the info center
 */
function template_ic_block_recent()
{
	global $context, $scripturl, $settings, $txt;

	if (empty($context['latest_posts']) || count($context['latest_posts']) <= 1)
		return;

	// This is the "Recent Posts" bar.
	echo '
	<div class="recent-posts lg:col-span-3 space-y-4">
			<div class="sub_bar">
				<h4 class="subbg">
					<a href="', $scripturl, '?action=recent"><i class="icon fas fa-comments"></i>', $txt['recent_posts'], '</a>
				</h4>
			</div>
			<div id="recent_posts_content" class="topic-item-container card">';

	// Show lots of posts.
	if (!empty($context['latest_posts']))
	{
		loadMemberData(array_map(function($post) {
			return $post['poster']['id'];
		}, $context['latest_posts']));

		/* Each post in latest_posts has:
			board (with an id, name, and link.), topic (the topic's id.), poster (with id, name, and link.),
			subject, short_subject (shortened with...), time, link, and href. */
		foreach ($context['latest_posts'] as $post)
		{
			loadMemberContext($post['poster']['id']);

			if (!empty($post['poster']['id']))
				$avatar = $GLOBALS['memberContext'][$post['poster']['id']]['avatar'];
			else
				$avatar = array('image' => '<img class="avatar" src="'.$GLOBALS['modSettings']['avatar_url'] . '/default.png'.'" alt="avatar">');

			echo '
			<ul class="contacts-list">
			<!-- Chat Item Start -->
			<li class="contacts-item friends">
							<div class="topic-item-poster-avatar">', $avatar['image'], '</div>
							<div class="contacts-content">
							<div class="contacts-info">
                                                <h6 class="chat-name text-truncate"><i class="icon fas fa-user"></i> ', $post['poster']['link'], '</h6>
                                                <div class="chat-time"><i class="icon far fa-clock"></i> ', $post['time'], '</div>
											</div>
											<div class="contacts-texts">
                                                <p class="text-truncate">', $post['link'], '</p>
                                                <div class="topic-item-board"><i class="icon fas fa-folder"></i> ', $post['board']['link'], '</div>
                                            </div>
							</div>
						</li>
                        <!-- Chat Item End -->
                 </ul>';
		}
	}
	echo '
			</div></div><!-- #recent_posts_content -->';
}

/**
 * The calendar section of the info center
 */
function template_ic_block_calendar()
{
	global $context, $scripturl, $txt;

	// Show information about events, birthdays, and holidays on the calendar.
	echo '
		<div class="boardindex-events">
			<div class="sub_bar">
				<h4 class="subbg">
					<a href="', $scripturl, '?action=calendar' . '"><i class="fa fa-calendar fa-lg"></i> ', $context['calendar_only_today'] ? $txt['calendar_today'] : $txt['calendar_upcoming'], '</a>
				</h4>
			</div>
			<div class="windowbg">
				<div class="databox databox--neutral databox--statistic">
					<div class="databox-icon"></div>
					<div class="databox-content">';

	// Holidays like "Christmas", "Chanukah", and "We Love [Unknown] Day" :P
	if (!empty($context['calendar_holidays']))
		echo '
			<p class="inline holiday">
				<span>', $txt['calendar_prompt'], '</span> ', implode(', ', $context['calendar_holidays']), '
			</p>';

	// People's birthdays. Like mine. And yours, I guess. Kidding.
	if (!empty($context['calendar_birthdays']))
	{
		echo '
			<p class="inline">
				<span class="birthday">', $context['calendar_only_today'] ? $txt['birthdays'] : $txt['birthdays_upcoming'], '</span>';

		// Each member in calendar_birthdays has: id, name (person), age (if they have one set?), is_last. (last in list?), and is_today (birthday is today?)
		foreach ($context['calendar_birthdays'] as $member)
			echo '
				<a href="', $scripturl, '?action=profile;u=', $member['id'], '">', $member['is_today'] ? '<strong class="fix_rtl_names">' : '', $member['name'], $member['is_today'] ? '</strong>' : '', isset($member['age']) ? ' (' . $member['age'] . ')' : '', '</a>', $member['is_last'] ? '' : ', ';

		echo '
			</p>';
	}

	// Events like community get-togethers.
	if (!empty($context['calendar_events']))
	{
		echo '
			<p class="inline">
				<span class="event">', $context['calendar_only_today'] ? $txt['events'] : $txt['events_upcoming'], '</span> ';

		// Each event in calendar_events should have:
		//		title, href, is_last, can_edit (are they allowed?), modify_href, and is_today.
		foreach ($context['calendar_events'] as $event)
			echo '
				', $event['can_edit'] ? '<a href="' . $event['modify_href'] . '" title="' . $txt['calendar_edit'] . '"><i class="fa fa- fa-lg"></i></a> ' : '', $event['href'] == '' ? '' : '<a href="' . $event['href'] . '">', $event['is_today'] ? '<strong>' . $event['title'] . '</strong>' : $event['title'], $event['href'] == '' ? '' : '</a>', $event['is_last'] ? '<br>' : ', ';
		echo '
			</p>';
	}

	echo '
					</div>
				</div>
			</div>
		</div>';
}

/**
 * The stats section of the info center
 */
function template_ic_block_stats()
{
	global $scripturl, $txt, $context, $settings;

	$stats = array(
		array(
			'label' => $txt['posts'],
			'value' => $context['common_stats']['total_posts'],
			'icon' => 'fas fa-comments',
		),
		array(
			'label' => $txt['topics'],
			'value' => $context['common_stats']['total_topics'],
			'icon' => 'fas fa-file-alt',
		),
		array(
			'label' => $txt['members'],
			'value' => $context['common_stats']['total_members'],
			'icon' => 'fas fa-users',
		),
		array(
			'label' => $txt['latest_member'],
			'value' => $context['common_stats']['latest_member']['link'],
			'icon' => 'fas fa-user',
		),
		array(
			'label' => $txt['latest_post'],
			'value' => !empty($context['latest_post']) ? "{$context['latest_post']['link']}" : '',
			'show' => !empty($context['latest_post']),
			'icon' => 'fas fa-reply',
		),
	);

	// Show statistical style information...
	echo '
	<div class="col-span-1">
			<div class="sub_bar">
				<h4 class="subbg">
					<a href="', $scripturl, '?action=stats" title="', $txt['more_stats'], '"><i class="fa fa-chart-area fa-lg"></i> ', $txt['forum_stats'], '</a>
				</h4>
			</div>
				<div class="forum-stats-container card sticky grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-1 top-4">';

	foreach ($stats as $stat)
	{
		if (array_key_exists('show', $stat) && empty($stat['show']))
			continue;

		echo '
		<ul class="contacts-list">
		<!-- Chat Item Start -->
		<li class="contacts-item states">
		<span class="col-1 text-center bg-c-green">
		<i class="', $stat['icon'], ' mat-icon f-24"></i> 
		</span>
						<div class="databox-content col-11">
						', $stat['label'], '
						<span class="floatright">', $stat['value'], '</span>
						</div>
						</li>
                        <!-- Chat Item End -->
                 </ul>';
	}

	echo '
				</div>
			</div></div>';
}

/**
 * The who's online section of the admin center
 */
function template_ic_block_online()
{
	global $context, $scripturl, $txt, $modSettings, $settings;
	// "Users online" - in order of activity.
	echo '
		<div class="users-online">
			<div class="sub_bar">
				<h4 class="subbg">
					', $context['show_who'] ? '<a href="' . $scripturl . '?action=who">' : '', '<i class="fa fa-users fa-lg"></i> ', $txt['online_users'], '', $context['show_who'] ? '</a>' : '', '
				</h4>
			</div>
			<div class="windowbgg">
				<div class="databox databox--neutral databox--statistic">
					<div class="databox-icon"><i class="icon fas fa-users"></i></div>
					<div class="databox-content">
						<div class="databox-title">
							', $context['show_who'] ? '<a href="' . $scripturl . '?action=who">' : '', '', comma_format($context['num_guests']), ' ', $context['num_guests'] == 1 ? $txt['guest'] : $txt['guests'], ', ', comma_format($context['num_users_online']), ' ', $context['num_users_online'] == 1 ? $txt['user'] : $txt['users'];

	// Handle hidden users and buddies.
	$bracketList = array();

	if ($context['show_buddies'])
		$bracketList[] = comma_format($context['num_buddies']) . ' ' . ($context['num_buddies'] == 1 ? $txt['buddy'] : $txt['buddies']);

	if (!empty($context['num_spiders']))
		$bracketList[] = comma_format($context['num_spiders']) . ' ' . ($context['num_spiders'] == 1 ? $txt['spider'] : $txt['spiders']);

	if (!empty($context['num_users_hidden']))
		$bracketList[] = comma_format($context['num_users_hidden']) . ' ' . ($context['num_spiders'] == 1 ? $txt['hidden'] : $txt['hidden_s']);

	if (!empty($bracketList))
		echo ' (' . implode(', ', $bracketList) . ')';

	echo $context['show_who'] ? '</a>' : '', '

						</div>
						<div class="databox-text">

				', $txt['most_online_today'], ': <strong>', comma_format($modSettings['mostOnlineToday']), '</strong>&nbsp;-&nbsp;
				', $txt['most_online_ever'], ': ', comma_format($modSettings['mostOnline']), ' (', timeformat($modSettings['mostDate']), ')<br>';

	// Assuming there ARE users online... each user in users_online has an id, username, name, group, href, and link.
	if (!empty($context['users_online']))
	{
		echo '
				', sprintf($txt['users_active'], $modSettings['lastActive']), ': ', implode(', ', $context['list_users_online']);

		// Showing membergroups?
		if (!empty($settings['show_group_key']) && !empty($context['membergroups']))
			echo '
				<span class="membergroups">' . implode(', ', $context['membergroups']) . '</span>';
	}

	echo '
						</div>
					</div>
				</div>
			</div>
		</div>';
}
function vision_divbox()
{
	global $settings;
	if (!empty($settings['vision_divbox']))
	{
	echo'
	<div id="quick-touch-page-content" class="quick-touch-section">
	<div class="p-quick-touch-inner">';
		if(!empty($settings['vision_divbox1']))
		echo'
		<div class="quick-touch-block ask">
			<div class="quick-touch-body">
		<div class="quick-touch_icon blue divbox-'.$settings['vision_divbox1_color'].'">
			<span class="quick-touch_crown">',!empty($settings['vision_title1_fa'])?'<i class="fab '.$settings['vision_title1_fa'].'"></i>':'','</span>
		</div>
		<div class="icon-box-body">',!empty($settings['vision_title1'])?'<h2 class="divboxtitlebg">'.$settings['vision_title1'].'</h2>':'','
		<p>'.$settings['vision_divbox1'].'</p></div>
			</div></div>';
		
		if(!empty($settings['vision_divbox2']))
		echo'
		<div class="quick-touch-block answer">
			<div class="quick-touch-body">
		<div class="quick-touch_icon green divbox-'.$settings['vision_divbox2_color'].'">
		<span class="quick-touch_crown">',!empty($settings['vision_title2_fa'])?'<i class="fab '.$settings['vision_title2_fa'].'"></i>':'','</span>
		</div>
		<div class="icon-box-body">',!empty($settings['vision_title2'])?'<h2 class="divboxtitlebg">'.$settings['vision_title2'].'</h2>':'','
		<p>'.$settings['vision_divbox2'].'</p></div>
			</div></div>';	
		
		if(!empty($settings['vision_divbox3']))
		echo'
		<div class="quick-touch-block expert">
			<div class="quick-touch-body">
		<div class="quick-touch_icon red divbox-'.$settings['vision_divbox3_color'].'">
		<span class="quick-touch_crown">',!empty($settings['vision_title3_fa'])?'<i class="fab '.$settings['vision_title3_fa'].'"></i>':'','</span>
		</div>
		<div class="icon-box-body">',!empty($settings['vision_title3'])?'<h2 class="divboxtitlebg">'.$settings['vision_title3'].'</h2>':'','
		<p>'.$settings['vision_divbox3'].'</p></div>
			</div></div>';
	echo'
	</div></div>';
	}
}
?>