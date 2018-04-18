<form class="float-right" action="{{ route('authors.destroy', $author_id) }}" method="post">
    @csrf
    @method('DELETE')

        <a href="{{ $show_url }}" class="btn btn-primary">Detail</a>
        <a href="{{ $edit_url }}" class="btn btn-warning">Edit</a>
        <button type="submit" class="btn btn-danger">Delete</button>
</form>