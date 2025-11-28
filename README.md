## ■ MEOW HOME
![ogp](https://github.com/user-attachments/assets/4ef7c153-0d63-46d4-88e8-9b3674228178)

## ■ アプリURL
https://www.meowhome.jp/

## ■ サービス概要
猫に特化した譲渡マッチングアプリです。

## ■ アプリを作ったキッカケ
興味のあったPHP・Laravelを学んだことで、実際に何か作りたいと考えました。<br>
私自身が２匹の猫と暮らす愛猫家であることもあり、以前より関心のあった保護猫活動に少しでも役立てればと思い、猫特化の譲渡マッチングアプリを作成することに決めました。

## ■ アプリに込めた思い・実現したい未来
*年々減少傾向ではありますが、猫の殺処分は犬の３倍、そのうちの６割は子猫です。<br>
2023年度の猫の殺処分数は６,８９９頭であり、現在でも１日に約１９頭が殺処分により命を奪われています。*<br><br>

保護猫に限らず１匹でも多くの猫が、あたらしいおうちに迎えられるお手伝いができたら。<br>
"ずっとのおうち"を見つけて、身も心も温かな時間を過ごせたら。<br>
あたらしい我が家「new home」、ただいまという意味の「I'm home (now)」、猫の鳴き声「meow」<br>
猫も ひとも ともに幸せに暮らすための縁をつなぐ場所になってほしいという思いを **MEOW HOME** に込めました。<br>

## ■ 主なページと機能
<table>
  <tr>
      <th width="500">
          Topページ
      </th>
      <th width="500">
          ユーザ登録ページ
      </th>
  </tr>
  <tr>
      <td>
          <img width="1470" height="829" alt="welcome_page" src="https://github.com/user-attachments/assets/75600296-ee7f-4e8d-96ea-8f2132f83606" />
      </td>
      <td>
        <img width="1920" height="989" alt="signup" src="https://github.com/user-attachments/assets/9447b5d9-b973-41fd-a4b3-d92fff952326" />
      </td>
  </tr>
  <tr>
      <td>
          Topページはシンプルなデザインを意識し、サービスの特徴が把握しやすいように工夫しました。
      </td>
      <td>
          ユーザーにわかりやすい設計を意識しました。
      </td>
  </tr>
</table>

<table>
  <tr>
      <th width="500">
          ログインページ
      </th>
      <th width="500">
          ユーザ詳細・編集ページ
      </th>
  </tr>
  <tr>
      <td>
          <a href="https://gyazo.com/e4928657d0d38b61f974dbc214e75827"><img src="https://i.gyazo.com/e4928657d0d38b61f974dbc214e75827.gif" alt="Image from Gyazo" width="470"/></a>
      </td>
      <td>
          <a href="https://gyazo.com/b607dca8d39d8458697278fc2c6234e5"><img src="https://i.gyazo.com/b607dca8d39d8458697278fc2c6234e5.gif" alt="Image from Gyazo" width="470"/></a>
      </td>
  </tr>
  <tr>
      <td>
          ブラウザを閉じてもログインを継続させるため、ログイン保持機能を実装しました。
      </td>
      <td>
      </td>
  </tr>
</table>

<table>
  <tr>
      <th width="500">
          新規募集作成・編集ページ
      </th>
      <th width="500">
          マイ募集一覧ページ
      </th>
  </tr>
  <tr>
      <td>
          <a href="https://gyazo.com/aeceeb9d0edd022d06670d073c25ae79"><img src="https://i.gyazo.com/aeceeb9d0edd022d06670d073c25ae79.gif" alt="create_post" width="470"/></a>
      </td>
      <td>
          <a href="https://gyazo.com/7250b483eee2db5b28aa417dcfe79c1d"><img src="https://i.gyazo.com/7250b483eee2db5b28aa417dcfe79c1d.gif" alt="my_posts" width="470"/></a>
      </td>
  </tr>
  <tr>
      <td>
      </td>
      <td>
      </td>
  </tr>
</table>

<table>
  <tr>
      <th width="500">
      </th>
      <th width="500">
      </th>
  </tr>
  <tr>
      <td>
          <a href="https://gyazo.com/a7f8051ea6931b7a8c75905b010ac41e"><img src="https://i.gyazo.com/a7f8051ea6931b7a8c75905b010ac41e.gif" alt="matchings" width="470"/></a>
      </td>
      <td>
          <img width="1470" height="830" alt="likes" src="https://github.com/user-attachments/assets/438b1337-8013-4393-90df-c2f8293ac14d" />
      </td>
  </tr>
  <tr>
      <td>
      </td>
      <td>
      </td>
  </tr>
</table>

<table>
  <tr>
      <th width="500">
          
      </th>
      <th width="500">
          マイページ
      </th>
  </tr>
  <tr>
      <td>
          
      </td>
      <td>
          <img width="1470" height="829" alt="mypage" src="https://github.com/user-attachments/assets/e19d12a7-ccb2-4e09-a7b5-36d736c3cd8d" />
      </td>
  </tr>
  <tr>
      <td>
      </td>
      <td>
          こちらから退会も可能です。
      </td>
  </tr>
</table>


## ■ 使用技術

#### バックエンド
- PHP 8.3.26
- Laravel 12.32.5
- Node.js 24.8.0 / npm 11.6.0
- composer 2.8.12

#### フロントエンド
- HTML
- CSS（SCSS）
- Bootstrap
- JavaScript ES2025

#### インフラ
- AWS ( EC2, RDS, Route53, Certificate Manager, VPC )
- 本番: AmazonLinux 2023 / 開発: MacOS Sequoia 15.6.1
- Docker 28.4.0 / docker-compose 2.39.2
- Apache 2.4.62
- MySQL 8.0.43 / phpMyAdmin


## ■ インフラ構成図
<p align="center">
  <img src="https://github.com/user-attachments/assets/1e80c349-f8a8-44e3-a49f-4ac71458b104" />
</p>
