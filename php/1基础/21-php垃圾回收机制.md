  
    php5.3版本以前：php垃圾回收机制是基于引用计数，当一个变量的引用计数为0，php会认为该变量为垃圾，然后会对该变量进行内存回收。如果变量没有被使用是环形引用时，则会发生内存泄露，因为引用计数不为0。
  
    php5.3版本以后：仍然以引用计数为基础，但是对引用计数进行了优化，他会计算变量的引用数和该变量内部元素指向该变量的计数，如果两者相等（其实就是环形引用），则会将该变量加入的可能根缓冲区里面，当缓冲区满了或者手动执行gc_collect_cycle()函数，则php会将缓冲区里面的变量内存进行回收。
    
    假设数组 a 的 refcount 等于 m，a 中有 n 个元素又指向 a，如果 m == n，那么判断 m - n = 0，那么 a 就是垃圾，如果 m > n，那么算法的结果 m - n > 0，所以 a 就不是垃圾了。