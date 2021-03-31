<?php //view used for 'postCreate' and 'postEdit'?>
<main>
    <div class="container">
        <h1><?=$data['title']?></h1>
        <div class="row">
            <form method="post" class="col-md-8 mx-auto">
                <div>
                    <label for="pContent"></label>
                    <textarea name="pContent" id="pContent"><?php if(isset($data['post']['content'])) echo $data['post']['content']; ?></textarea>
                </div>
                
                <input type="submit" class="btn btn-primary" value="<?= $data['submitMessage']?>">
            </form>
        </div>
    </div>
</main>