<?php
namespace Szwss\ChinaAddress;

trait AddressTrait
{
    public function parent()
    {
        if ($this->parent_code) {
            return self::find($this->parent_code);
        }
        return false;
    }

    public function children(){
        return self::where('parent_code', $this->code)->get();
    }

    public function allChildren()
    {
        $children1 = $this->children();

        if ($children1->count()) {
            foreach ($children1 as $child1) {
                $children2 = $this->getChildren($child1->code);

                if ($children2->count()) {
                    $child1->children = $children2;

                    foreach ($children2 as $child2) {
                        $children3 = $this->getChildren($child2->code);

                        if ($children3->count()) {
                            $child2->children = $children3;
                        }
                    }
                }
            }
        }
        return $children1;
    }
    private function getChildren($code)
    {
        return self::where('parent_code', $code)->get();
    }

    public function getFullPath($joiner = ' ')
    {
        $path = $this->name;
        return $this->getPath($path, $this->parent_code, $joiner);
    }
    private function getPath($path, $code, $joiner)
    {
        if ($code) {
            $parent = $this->find($code);
            if ($parent) {
                return $this->getPath($parent->name . $joiner . $path, $parent->parent_code, $joiner);
            }
        }
        return $path;
    }


}