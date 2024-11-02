    <div class="toast-container p-3 end-0 bottom-0">
        <div class="toast text-bg-danger" role="alert" id="toastStok" aria-live="polite" aria-atomic="true" data-bs-delay="4000">
            <div class="toast-header">        
                <strong class="me-auto">Perhatian</strong>                
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Terdapat Barang dengan Stok yang Menipis. Segera Re-Stok!
            </div>
        </div>
    </div>

<script src="../../bootstrap-5.3.3/js/bootstrap.min.js"></script>
    
<script>
    let ElToastStok = document.getElementById('toastStok');
    if(ElToastStok) {
        let toastStok = new bootstrap.Toast(ElToastStok);
        toastStok.show();
    }
</script>

</body>
</html>