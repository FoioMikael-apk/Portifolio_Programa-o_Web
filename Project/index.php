<?php   
    include('layouts/header.php');
?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h2 class="card-title text-center text-primary mb-4">Qual é o Seu Signo?</h2>
                    
                    <form action="show_zodiac_sign.php" method="POST">
                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                            
                            <input 
                                type="date" 
                                class="form-control form-control-lg" 
                                id="data_nascimento" 
                                name="data_nascimento" 
                                required
                            >
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg mt-3">Descobrir Signo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>