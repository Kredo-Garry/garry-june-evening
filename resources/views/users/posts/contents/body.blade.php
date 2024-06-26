{{-- clickable image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>

<div class="card-body">
    <div class="row align-items-center">
            {{-- heart icon + no of likes + categories --}}
        <div class="col-auto">

            @if ($post->isLiked())
                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-solid fa-heart text-danger"></i></button>
                </form>
            @else
                <form action="{{ route('like.store', $post->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
                </form>
            @endif


            
        </div>
        <div class="col-auto px-0">
            <span>{{ $post->likes->count() }}</span>
        </div>
        <div class="col text-end">

            @forelse ($post->categoryPost as $category_post)
                <span class="badge bg-secondary bg-opacity-50">
                    {{ $category_post->category->name }}
                </span>
            @empty
                <div class="badge bg-dark text-wrap">Uncategorized</div>
            @endforelse

        </div>
    </div>


    {{-- Owner of the post + Description of the post--}}
    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
    &nbsp;
    <p class="d-inline fw-light">{{ $post->description }}</p>
    &nbsp;

    <p class="text-danger small">Posted in {{ $post->created_at->diffForHumans() }}</p>

    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
    {{-- 
        date(format, unix time)
        
        The strtotime() is a function. A built-in function in php use to convert the time
        into a string and readable to human.

        strtotime(timestamp) --> 1547855852 <--- time()
        strtotime('June 7, 2024 11:57:31')

        date('June 7, 2024')

     --}}

    {{-- include comments here --}}
    @include('users.posts.contents.comments')

</div>