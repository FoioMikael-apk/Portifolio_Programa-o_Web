<?php
    // 1. Inclui o arquivo de topo (header)
    include('layouts/header.php');

    $signo_encontrado = null;

    if (isset($_POST['data_nascimento']) && !empty($_POST['data_nascimento'])) {
        $data_nascimento_str = $_POST['data_nascimento'];
        
        // Converte a string de data (Y-m-d) para um objeto DateTime
        $data_nascimento = new DateTime($data_nascimento_str);
        // Pega o ano de nascimento do usuário
        $ano_nascimento = $data_nascimento->format('Y');

        // 2. Cria a variável para manipular o arquivo XML
        $signos = @simplexml_load_file("signos.xml");

        if ($signos !== false) {
            
            // 3. Itera sobre a lista de signos no XML
            foreach ($signos->signo as $signo) {
                
                $data_inicio_str = (string)$signo->dataInicio;
                $data_fim_str = (string)$signo->dataFim;

                // 4. Cria objetos DateTime para as datas de início e fim no ano do usuário
                $data_inicio = DateTime::createFromFormat('d/m/Y', $data_inicio_str . '/' . $ano_nascimento);
                $data_fim = DateTime::createFromFormat('d/m/Y', $data_fim_str . '/' . $ano_nascimento);
                
                // 5. Lógica para signos que cruzam a virada do ano (ex: Capricórnio)
                // Se a data de início for *maior* que a data de fim, ajusta o ano de um dos lados.
                if ($data_inicio > $data_fim) {
                    if ($data_nascimento < $data_inicio) {
                        // Ex: DataNasc: 15/01/2025. DataFim: 20/01/2025. DataInicio: 22/12/2024.
                        // Ajusta a data de início para o ano anterior.
                        $data_inicio = DateTime::createFromFormat('d/m/Y', $data_inicio_str . '/' . ($ano_nascimento - 1));
                    } else {
                        // Ex: DataNasc: 25/12/2024. DataInicio: 22/12/2024. DataFim: 20/01/2025.
                        // Ajusta a data de fim para o ano seguinte.
                        $data_fim = DateTime::createFromFormat('d/m/Y', $data_fim_str . '/' . ($ano_nascimento + 1));
                    }
                }

                // 6. Verifica se a data de nascimento está dentro do range
                if ($data_nascimento >= $data_inicio && $data_nascimento <= $data_fim) {
                    $signo_encontrado = $signo;
                    break; // Sai do loop
                }
            }
        }
    }

?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg p-4 bg-light rounded">
            <div class="card-body text-center">
                <?php if ($signo_encontrado): ?>
                    <h2 class="card-title display-4 text-success mb-4">Parabéns!</h2>
                    <p class="lead">Sua data de nascimento é: **<?php echo $data_nascimento->format('d/m/Y'); ?>**</p>
                    <hr>
                    
                    <h3 class="text-primary mt-4">Seu Signo é: <span class="fw-bold"><?php echo (string)$signo_encontrado->nome; ?></span></h3>
                    
                    <p class="text-muted">Período: <?php echo (string)$signo_encontrado->dataInicio; ?> a <?php echo (string)$signo_encontrado->dataFim; ?></p>
                    
                    <p class="fs-5 mt-3"><?php echo (string)$signo_encontrado->descricao; ?></p>
                    
                <?php else: ?>
                    <h2 class="card-title text-danger mb-4">Erro!</h2>
                    <p class="lead">Não foi possível determinar o signo zodiacal. Por favor, volte e tente novamente.</p>
                <?php endif; ?>

                <div class="mt-5">
                    <a href="index.php" class="btn btn-outline-primary btn-lg">← Voltar para a Página Inicial</a>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>