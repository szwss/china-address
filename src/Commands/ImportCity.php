<?php

namespace Szwss\ChinaAddress\Commands;

use Illuminate\Console\Command;
use Szwss\ChinaAddress\Address;

class ImportAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the address table with address json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Address::count()) {
            return $this->error('数据库有数据，请先清理数据库');
        }
        $this->seeding('直辖市','pcas-code-zxs.json');
        $this->seeding('省份','pcas-code.json');
    }

    private function seeding($type,$file_name)
    {
        // 从文件中读取数据到PHP变量
        $json_string = file_get_contents(__DIR__.'/../../'.$file_name);
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
        // 显示出来看看
        // var_dump($json_string);
        // var_dump ($data);
        $this->info('Start Seeding '.count($data).' '.$type.'...');

        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        foreach ($data as $item) {
            $code = $item['code'];
            $create = array('code'=>$code,'name'=>$item['name']);
            Address::create($create);

            if(isset($item['children'])){ // && count($item['children']) > 0
                $this->foreach($item['children'],$code);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info('---'.$type.' Seed finished...');
    }
    private function foreach(array $array,$parent_code)
    {
        foreach ($array as $item) {
            $code = $item['code'];
            $array1 = array('code'=>$code,'name'=>$item['name'],'parent_code'=>$parent_code);

            Address::create($array1);

            if(isset($item['children'])) {
                $this->foreach($item['children'],$code);
            }
        }
    }
}
