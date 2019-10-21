# vi/vim


##  1、模式：
> 一般模式、编辑模式和命令行模式
      
      一般模式：删除、复制和粘贴
              dd pp
      切换到编辑模式：
              i I ：光标在当前位置
              o O ：往上/下新开一行编辑
              a A ：光标移到下一个位置
              r R :替换当前字符
      
      切换到命令行模式：
              : 
              / 
              ?
  
      查找：
        /字符串
        ?字符串
      
      替换：
        :n1,n2s/word1/word2/g
           n1-n2行进行替换
        :1,$s/word1/word2/g
           从1到尾行进行替换
        :1,$s/word1/word2/gc
        :s/word1/word2/g
        
        g是全局替换，不带每行只会替换一次。
        
     删除：
       x：往后删除一个字符
       X：往前删除一个字符
       dd：删除整行
       ndd:
       yy：复制整行
       nyy:
       p：粘贴到下一行
       P：粘贴到上一行
       ctrl+r：
       .:复制当前行到当前行
       
      保存退出：
       w
       q
       wq
       e!：相当于不保存再重新打开文件
        
        
    vim视图功能：
       v：visual
       V：visual line
       crtl+v ： visual block
       y
       d
     按v、V、ctrl+v进入视图模式，按y复制，按d删除
  
    配置：
    set number:set nu,显示行号
    set nonumber:set nonu,不显示行号