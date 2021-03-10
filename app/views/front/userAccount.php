<main class="container">
    <h1><?=$data['title']?></h1>
    <table>
        <tr>
            <td>Pseudo</td>
            <td><?php if(isset($data['user']['pseudo'])) echo $data['user']['pseudo']?></td>
        </tr>
        <tr>
            <td>Prénom</td>
            <td><?php if(isset($data['user']['firstname'])) echo $data['user']['firstname']?></td>
        </tr>
        <tr>
            <td>Nom</td>
            <td><?php if(isset($data['user']['name'])) echo $data['user']['name']?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php if(isset($data['user']['email'])) echo $data['user']['email']?></td>
        </tr>
        <tr>
            <td>Promotion</td>
            <td><?php if(isset($data['user']['promotion'])) echo $data['user']['promotion']?></td>
        </tr>
        <tr>
            <td>Poste actuel</td>
            <td><?php if(isset($data['user']['job'])) echo $data['user']['job']?></td>
        </tr>
        <tr>
            <td>Réseaux</td>
            <td>
                <table>
                    <tr>
                        <td>Site personnel</td>
                        <td><?php if(isset($data['user']['socials']['own_website'])) echo $data['user']['socials']['own_website']?></td>
                    </tr>
                    <tr>
                        <td>Github</td>
                        <td><?php if(isset($data['user']['socials']['github'])) echo $data['user']['socials']['github']?></td>
                    </tr>
                    <tr>
                        <td>Linkedin</td>
                        <td><?php if(isset($data['user']['socials']['linkedin'])) echo $data['user']['socials']['linkedin']?></td>
                    </tr>
                    <tr>
                        <td>Discord</td>
                        <td><?php if(isset($data['user']['socials']['discord'])) echo $data['user']['socials']['own_website']?></td>
                    </tr>
                    <tr>
                        <td>Codepen</td>
                        <td><?php if(isset($data['user']['socials']['own_website'])) echo $data['user']['socials']['own_website']?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</main>