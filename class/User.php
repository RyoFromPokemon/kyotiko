<?php

class User{
    /**
     * ID
     */
    private $id;
    /**
     * ユーザーネーム
     */
    private $userName;
    /**
     * 姓
     */
    private $name;
    /**
     * お気に入りの観光地
     */
    private $favoris;
    /**
     * メールアドレス
     */
    private $email;
    /**
     * パスワード
     */
    private $password;
    /**
     * TOP画像
     */
    private $picture;
    /**
     * TメンバーID
     */
    private $memberId;
    

    //以下アクセサメソッド。

    public function getId(): ?int{
        return $this->id;
    }
    public function setId(string $id):void{
        $this->id = $id;
    }
    public function getUserName(): ?string{
        return $this->userName;
    }
    public function setUserName(string $userName):void{
        $this->userName = $userName;
    }
    public function getName(): ?string{
        return $this->name;
    }
    public function setName(string $name):void{
        $this->name = $name;
    }
    public function getEmail(): ?string{
        return $this->email;
    }
    public function setEmail(?string $email):void{
        $this->email = $email;
    }
    public function getFavoris(): ?string{
        return $this->favoris;
    }
    public function setFavoris(?string $favoris):void{
        $this->favoris = $favoris;
    }
    public function getPassword(): ?string{
        return $this->password;
    }
    public function setPassword(?string $password):void{
        $this->password = $password;
    }
    public function getPicture(): ?string{
        return $this->picture;
    }
    public function setPicture(?string $picture):void{
        $this->picture = $picture; 
    }
    public function getMemberId(): ?string{
        return $this->memberId;
    }
    public function setMemberId(?string $memberId):void{
        $this->memberId = $memberId;
    }
}
