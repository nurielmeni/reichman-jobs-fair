<html lang="he">

<head>
    <meta charset="utf-8" />
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
        }

        #nls-wrapper {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            min-height: 400px;
        }

        #nls-wrapper>h1 {
            width: 100%;
            background: #490f35;
            margin: 0;
            padding: 10px 20px;
            color: #fff;
            box-sizing: border-box;
            text-align: center;
            border: 2px solid #1672ba;
            border-bottom: none;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        #nls-wrapper>h1>img {
            width: 100%;
            padding: 0 155px;
            box-sizing: border-box;
        }

        #nls-wrapper table {
            direction: rtl;
            table-layout: fixed;
            padding: 50px 20px;
            font-size: 16px;
            width: 100%;
            border-left: 2px solid #1672ba;
            border-right: 2px solid #1672ba;
        }

        #nls-wrapper table td.label {
            width: 150px;
            background-color: #eaeaea;
            padding: 5px 20px;
            text-align: left;
        }

        #nls-wrapper table td.value {
            padding-right: 20px;
            border: 1px solid #eaeaea;
        }

        #nls-wrapper footer {
            box-sizing: border-box;
            background-color: #828282;
            bottom: 0;
            width: 100%;
            border: 2px solid #1672ba;
            border-top: none;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        #nls-wrapper footer>p {
            margin: 0;
            padding: 10px;
            text-align: center;
            color: #fff;
        }
    </style>
</head>

<body>
    <div id="nls-wrapper">
        <h1><?= __('Applied CV from Jobs Site', 'NlsHunterFbf') ?></h1>
        <table>
            <?php foreach ($fields as $field) : ?>
                <?php if (is_array($field['value']) || !empty($field['value'])) : ?>
                    <tr>
                        <td class="label"><strong><?= $field['label'] ?></strong></td>
                        <td class="value"><?= is_array($field['value']) ? $field['value'][$i] : $field['value'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <footer>
            <p><?= get_bloginfo('name') ?> - Powered by NILOOSOFT HUNTER EDGE</p>
        </footer>
    </div>
</body>
<html>