import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function () {
    console.log('newsfeed-realtime.js loaded');

    if (typeof window.Echo === 'undefined') {
        console.warn('Echo is not initialized');
        return;
    }
$('.card[id^="post-"]').each(function() {
        const postId = $(this).attr('id').replace('post-', '');
        if (postId) {
            subscribeToPostChannel(postId);
        }
    });
    $(document).on('click', '.like-form button', function(e) {
        e.preventDefault();
    const postId = $(this).data('post-id'); 
    const $form  = $(this).closest('form');
    const url    = $form.attr('action');

    console.log('Post ID:', postId); 

        subscribeToPostChannel(postId);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
  success: function (response) {
    
    const $post = $('#post-' + postId);
    $post.find('.likes-number').text(response.likes_count);

    const $btn  = $form.find('button');

    if (response.liked) {
        $btn.html('<i class="fas fa-thumbs-down"></i> Unlike');

        $form.attr('action', `/posts/${postId}/unlike`);
    } else {
        $btn.html('<i class="fas fa-thumbs-up"></i> Like');

        $form.attr('action', `/posts/${postId}/like`);
    }
}

,
            error: function(xhr) {
                console.error('Like action failed:', xhr);
            }
        });
    });

    $(document).on('submit', '.comment-form', function(e) {
        e.preventDefault();
        const $form = $(this);
        const url = $form.attr('action');
        const postId = $form.data('post-id'); 
        subscribeToPostChannel(postId);

        const $textarea = $form.find('.comment-textarea');

        $.ajax({
            url: url,
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                console.log('Comment added successfully', response);
                $textarea.val('');
            },
            error: function(xhr) {
                console.error('Comment action failed:', xhr);
            }
        });
    });

    function subscribeToPostChannel(postId) {
        if (!postId) return;

        if (window.subscribedPosts && window.subscribedPosts.includes(postId)) {
            return;
        }

        window.subscribedPosts = window.subscribedPosts || [];
        window.subscribedPosts.push(postId);

        window.Echo.channel(`posts.${postId}`)
            .listen('.App\\Events\\PostLiked', (data) => {
                console.log('Like event received for post', postId, data);
                handleLikeEvent(postId, data);
            })
            .listen('.App\\Events\\CommentAdded', (data) => {
                console.log('Comment event received for post', postId, data);
                handleCommentEvent(postId, data);
            });
    }

    function handleLikeEvent(postId, data) {
        const $post = $(`#post-${postId}`);
        if ($post.length === 0) return;

        $post.find('.likes-number').text(data.likes_count);
        $post.find('.likes-count').addClass('text-success');
        setTimeout(() => {
            $post.find('.likes-count').removeClass('text-success');
        }, 500);

        updateLikesList(postId, data);
    }

    function updateLikesList(postId, data) {
        const $likesList = $(`#likesModal${postId} .likes-list`);
        if ($likesList.length === 0) return;

        const $existingLike = $likesList.find('span').filter(function() {
            return $(this).text() === data.user_name;
        }).parent();

        if ($existingLike.length > 0) {
            $existingLike.remove();
        } else {
            const likeHtml = `
                <li class="list-group-item d-flex align-items-center">
                    <img src="${data.user_avatar}" class="rounded-circle me-2" width="40" height="40" alt="User Image">
                    <span>${data.user_name}</span>
                </li>
            `;
            $likesList.append(likeHtml);
        }
    }

    function handleCommentEvent(postId, data) {
        const $post = $(`#post-${postId}`);
        if ($post.length === 0) return;

        const commentHtml = `
            <div class="d-flex align-items-center mb-2 new-comment" style="display: none;">
                <img src="${data.user_avatar}" class="rounded-circle me-2" width="40" height="40" alt="User Image">
                <div class="bg-light p-2 rounded" style="flex-grow: 1;">
                    <strong>${data.user_name}</strong> <small class="text-muted">${data.created_at}</small>
                    <p class="mb-0">${data.content}</p>
                </div>
            </div>
        `;

        const $commentsSection = $post.find('.comments');
        if ($commentsSection.length > 0) {
            $commentsSection.append(commentHtml);
            $commentsSection.find('.new-comment:last').fadeIn(500);
        }

        const $commentsCount = $post.find('.comments-count');
        const currentCount = parseInt($commentsCount.text()) || 0;
        $commentsCount.text(currentCount + 1);
    }
});
$(document).on('click', '.comment-hiden', function() {
    const $postCard = $(this).closest('.card-body');
    const $commentsSection = $postCard.find('.comments');
    const $commentForm = $postCard.find('.comment-form');
    $commentsSection.slideToggle(300);
    $commentForm.slideToggle(300);
});