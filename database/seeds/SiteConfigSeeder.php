<?php

use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_config')->insert([
            'title'=>'淡村书画院',
            'keywords'=>'书画,藏品,艺术品,古玩',
            'description'=>'淡村书画院淡村书画院淡村书画院淡村书画院',
            'copyright'=>'Copyright Reserved 2000-2015 雅昌艺术网 版权所有<br />电信与信息服务业务经营许可证（粤）B2-20030053广播电视制作经营许可证（粤）字第717号　<br />京公网安备 11011302000792号信息网络传播视听节目许可证1909402号粤ICP备11054908号-15企业法人营业执照<br />网络文化经营许可证文网文［2009］086号互联网出版许可证［2010］445号可信网站验证服务证书2012040503023850号<br />'
        ]);
        DB::table('site_friendlink')->insert([
            'link_name'=>'百度',
            'link_img'=>'uploads/2017/06_02/friendlink.png',
            'link_url'=>'http://www.baidu.com',
            'rank'=>'1',
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('site_banner')->insert([
            'name'=>'百度',
            'url'=>'http://www.baidu.com',
            'img'=>'uploads/2017/06_02/banner.jpg',
            'rank'=>1,
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('site_banner')->insert([
            'name'=>'谷歌',
            'url'=>'http://www.google.com',
            'img'=>'uploads/2017/06_02/banner1.jpg',
            'rank'=>1,
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
