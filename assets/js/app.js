/* =====================
   MODAL HANDLER
===================== */
function openModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.remove('hidden');
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.add('hidden');
}

/* =====================
   EDIT BUKU MODAL
===================== */
function openEditModal(data) {
  if (!data) return;

  document.getElementById('edit_id').value = data.isbn;
  document.getElementById('edit_isbn_display').value = data.isbn;
  document.getElementById('edit_judul').value = data.judul;
  document.getElementById('edit_pengarang').value = data.pengarang;
  document.getElementById('edit_penerbit').value = data.penerbit;
  document.getElementById('edit_tahun').value = data.tahun;
  document.getElementById('edit_genre').value = data.genre;

  openModal('modalEdit');
}

/* =====================
   GLOBAL UX (OPTIONAL)
===================== */
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document
      .querySelectorAll('.modal:not(.hidden)')
      .forEach(m => m.classList.add('hidden'));
  }
});
