@props(['profileName' => 'Default Name', 'title', 'content', 'createdAt', 'post'])



<div class="box w-1">
    <div class="titles">
        <h2 class="h">{{ $post->title }}</h2>
        <span class="p-1">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <div class="b-1">
        <h3 class="h-1">{{ $profileName }}</h3>
        <p class="p-1">{{ $post->content }}</p>
    </div>
    <div class="b-2">
        <x-secondary-button class="button-space" type="submit">
            {{__('Like') }}
        </x-secondary-button>

        <x-secondary-button class="button-space" type="button" onclick="toggleCommentSection({{ $post->id }})">
            {{ __('Comment') }}
        </x-secondary-button>

        <x-secondary-button class="button-space" type="submit">
            {{__('Share') }}
        </x-secondary-button>
    </div>
    <!-- Hidden Comment Section -->
    <div id="comment-section-{{ $post->id  }}" class="comment-section" style="display: none;"">
        <form method="POST" action="{{ route('posts.comments.store', $post->id) }}">
            @csrf
            <x-textarea-input  name="content" class="block mt-1 w-full" rows="3" placeholder="Write a comment..."></x-textarea-input >
            <x-primary-button class="ms-3" type="submit">
                {{ __('Post Comment') }}
            </x-primary-button>
        </form>

        @foreach($post->comments as $comment)
        <div class="c">
            <div class="c-1">
                <strong class="c-profile c-2">{{ $comment->user->name }}</strong>
                <p class="c-content c-2">{{ $comment->content }}</p>
            </div>
            <span>{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div> 
</div>

