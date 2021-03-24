<?php

namespace MASKshop;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use MASKshop\Task\EffectTask;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\entity\Effect;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use pocketmine\item\Item;
use pocketmine\lang\BaseLang;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

use onebone\economyapi\EconomyAPI;

use jojoe77777\FormAPI;

class Main extends PluginBase implements Listener {
    
    /** @var Main $instance */
    private static $instance;
	
	public $plugin;

	public function onEnable() : void{
	    self::$instance = $this;
	    $this->getScheduler()->scheduleRepeatingTask(new EffectTask(), 20);
        $this->getLogger()->info(TextFormat::GREEN . "MASKbuatan Enable");
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
	}
	
	public static function getInstance() : self{
	    return self::$instance;
	}
   
     
     
    public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args) : bool {
		
		switch($cmd->getName()){
		
			case "mask":			    
			$this->FormSell($sender);
			return true;
		}
		return true;
	}
	
	public function FormSell($sender){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createSimpleForm(function(Player $sender, $data){
			$result = $data;
			if($result === null){
			}
			switch($result){
								
				case 0:
									
					break;
				case 1:
									
					   $money = $this->eco->myMoney($sender);
					$zombie = $this->getConfig()->get("money.zombie");
					if($money >= $zombie){
										
                       $this->eco->reduceMoney($sender, $zombie);
                       $sender->getInventory()->addItem(Item::get(397, 2, 1));
					   $sender->sendMessage($this->getConfig()->get("msg.shop.zombie"));
                      return true;
                    }else{
                       $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                    }
									
					break;
				case 2:
			               
					$money = $this->eco->myMoney($sender);
					$creeper = $this->getConfig()->get("money.creeper");
					if($money >= $creeper){
										
                       $this->eco->reduceMoney($sender, $creeper);
                       $sender->getInventory()->addItem(Item::get(397, 4, 1));
					   $sender->sendMessage($this->getConfig()->get("msg.shop.creeper"));
                      return true;
                    }else{
                       $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                    }
									
					break;
				case 3:
								    
					$money = $this->eco->myMoney($sender);
					$issuchitel = $this->getConfig()->get("money.issuchitel");
					if($money >= $issuchitel){
										
                       $this->eco->reduceMoney($sender, $issuchitel);
                       $sender->getInventory()->addItem(Item::get(397, 1, 1));
					   $sender->sendMessage($this->getConfig()->get("msg.shop.issuchitel"));
                      return true;
                    }else{
                       $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                    }
									
					break;
				case 4:
								    
					$money = $this->eco->myMoney($sender);
					$dragon = $this->getConfig()->get("money.dragon");
					if($money >= $dragon){
										
                       $this->eco->reduceMoney($sender, $dragon);
                       $sender->getInventory()->addItem(Item::get(397, 5, 1));
					   $sender->sendMessage($this->getConfig()->get("msg.shop.dragon"));
                      return true;
                    }else{
                       $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                    }
									
					break;
								
					}
					
				});
			    
			$money = $this->eco->myMoney($sender);
			$zombie = $this->getConfig()->get("money.zombie");
			$issuchitel = $this->getConfig()->get("money.issuchitel");
			$dragon = $this->getConfig()->get("money.dragon");
			$creeper = $this->getConfig()->get("money.creeper");
					
			$form->setTitle("§eMaskShop:Sylends");
			$form->setContent("§bUang Kamu Sekarang Adalah §a{$money}");
					
			$form->addButton("§cExit");
			$form->addButton("§dZombie = §a$".$zombie, 1, "https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/f/f8/Zombie_Head.png/150px-Zombie_Head.png?version=8a15fc74edd30aa4d804eb08247859a7");
			$form->addButton("§eCreeper = §a$".$creeper, 1, "https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/9/97/Creeper_Head.png/150px-Creeper_Head.png?version=94a13fb9d962554106e25c5a777fc9fd");
			$form->addButton("§cWither Skeleton = §a$".$issuchitel, 1, "https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/a/ac/Wither_Skeleton_Skull.png/150px-Wither_Skeleton_Skull.png?version=72391cd2dd387f87838d8e5af634a22f");
			$form->addButton("§bDragon = §a$".$dragon, 1, "https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/b/b6/Dragon_Head.png/150px-Dragon_Head.png?version=0687499d687de1761e5c0319c0ef6e86");
					
			$form->sendToPlayer($sender);
	}
}