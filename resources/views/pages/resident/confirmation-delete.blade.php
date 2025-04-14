
  <!-- Modal -->
  <div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/resident/{{ $item->id }}" method="post">
          @csrf
          @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <span>Apakah anda yakin untuk hapus data ini?</span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-outline-danger">Ya Hapus</button>
                </div>
              </div>
            </form>

      
    </div>
  </div>