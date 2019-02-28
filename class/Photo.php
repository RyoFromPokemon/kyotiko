<?php

class Photo{
    /**
     * ID
     */
    private $id;
    /**
     * 投稿写真
     */
    private $photo;
    /**
     * 観光地名
     */
    private $tourist;
    /**
     * お店の名前
     */
    private $shopName;
    /**
     * お店のurl
     */
    private $shopUrl;
    /**
     * 観光ルート
     */
    private $root;
    /**
     * コメント
     */
    private $comment;
    /**
     * 位置情報
     */
    private $gmap;
    /**
     * メンバーID
     */
    private $memberId;
    

    //以下アクセサメソッド。

    public function getId(): ?int{
        return $this->id;
    }
    public function setId(string $id):void{
        $this->id = $id;
    }
    public function getPhoto(): ?string{
        return $this->photo;
    }
    public function setPhoto(string $photo):void{
        $this->photo = $photo;
    }
    public function getShopName(): ?string{
        return $this->shopName;
    }
    public function setShopName(string $shopName):void{
        $this->shopName = $shopName;
    }
    public function getShopUrl(): ?string{
        return $this->shopUrl;
    }
    public function setShopUrl(string $shopUrl):void{
        $this->shopUrl = $shopUrl;
    }
    public function getTourist(): ?string{
        return $this->tourist;
    }
    public function setTourist(string $tourist):void{
        $this->tourist = $tourist;
    }
    public function getRoot(): ?string{
        return $this->root;
    }
    public function setRoot(?string $root):void{
        $this->root = $root;
    }
    public function getComment(): ?string{
        return $this->comment;
    }
    public function setComment(?string $comment):void{
        $this->comment = $comment;
    }
    public function getGmap(): ?string{
        return $this->gmap;
    }
    public function setGmap(?string $gmap):void{
        $this->gmap = $gmap;
    }
    public function getMemberId(): ?string{
        return $this->memberId;
    }
    public function setMemberId(?string $memberId):void{
        $this->memberId = $memberId;
    }
}
