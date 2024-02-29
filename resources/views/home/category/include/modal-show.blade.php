<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal{{ $row->id }}">
    <i class="bi bi-eye"></i>
</button>
<div class="modal fade" id="basicModal{{ $row->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Name: <strong class="text-uppercase fw-bold">{{ $row->name }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <img src="{{ $row->image }}" alt="image" class="img-thumbnail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
