
  <!-- Modal -->
  <div class="modal fade" id="confirmationReject-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationRejectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/account-request/approval/b{{ $item->id }}" method="post">
          @csrf
          @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title fs-5" id="confirmationRejectLabel">Konfirmasi Penolakan</h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="for" value="reject">
                  <span>Apakah anda yakin untuk tolak data ini?</span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-outline-danger">Ya, tolak</button>
                </div>
              </div>
            </form>
    </div>
  </div>